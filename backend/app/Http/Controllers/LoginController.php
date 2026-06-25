<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_MINUTES = 15;

    /**
     * Login user.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $throttleKey = Str::lower($email) . '|' . $request->ip();


        // Find user with role
        $user = User::with('Role')->where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            RateLimiter::hit($throttleKey, self::LOCKOUT_MINUTES * 60);

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        // Clear rate limiter on success
        RateLimiter::clear($throttleKey);

        // Generate Sanctum token
        $token = $user->createToken(
            'auth-token-' . $request->ip(),
            [$user->Role->name ?? 'user'] // use role name as ability
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data'    => [
                'user' => [
                    'id'         => $user->id,
                    'full_name'  => $user->full_name,
                    'email'      => $user->email,
                    'role'       => $user->Role->name ?? null,
                    'role_id'    => $user->role_id,
                ],
                'token'      => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Register new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
            'role_id'   => ['nullable', 'integer', 'exists:roles,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'full_name' => $request->input('full_name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'role_id'   => $request->input('role_id'), // null or provided
        ]);

        $user->load('Role');

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data'    => [
                'id'        => $user->id,
                'full_name' => $user->full_name,
                'email'     => $user->email,
                'role'      => $user->Role->name ?? null,
            ],
        ], 201);
    }

    /**
     * Get authenticated user with role.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('Role');

        return response()->json([
            'success' => true,
            'data'    => [
                'user' => [
                    'id'        => $user->id,
                    'full_name' => $user->full_name,
                    'email'     => $user->email,
                    'role'      => $user->Role->name ?? null,
                    'role_id'   => $user->role_id,
                ],
            ],
        ]);
    }

    /**
     * Refresh token.
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load('Role');

        $request->user()->currentAccessToken()->delete();

        $token = $user->createToken(
            'auth-token-' . $request->ip(),
            [$user->Role->name ?? 'user']
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed',
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Logout current device.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices',
        ]);
    }
}
