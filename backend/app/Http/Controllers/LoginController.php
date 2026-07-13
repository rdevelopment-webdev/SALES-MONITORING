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

    private function formatUser(User $user): array
    {
        $user->load('Role.rolePagePermissions.page');

        $permissions = $user->Role
            ? $user->Role->rolePagePermissions->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'role_id' => $permission->role_id,
                    'page_id' => $permission->page_id,
                    'permission_name' => $permission->permission_name,
                    'can_view' => (bool) $permission->can_view,
                    'can_create' => (bool) $permission->can_create,
                    'can_edit' => (bool) $permission->can_edit,
                    'can_archive' => (bool) $permission->can_archive,
                    'page' => $permission->page ? [
                        'id' => $permission->page->id,
                        'page_name' => $permission->page->page_name,
                    ] : null,
                ];
            })->values()
            : collect();

        return [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role' => $user->Role ? [
                'id' => $user->Role->id,
                'role_name' => $user->Role->role_name,
                'permissions' => $permissions,
            ] : null,
            'permissions' => $permissions,
        ];
    }

    private function passwordMatches(User $user, string $plainPassword): bool
{
    try {
        if (Hash::check($plainPassword, $user->password)) {
            return true;
        }
    } catch (\RuntimeException $e) {
        // Stored value isn't a valid bcrypt hash (e.g. legacy plaintext) — fall through.
    }

    if (hash_equals((string) $user->password, $plainPassword)) {
        $user->forceFill([
            'password' => Hash::make($plainPassword),
        ])->save();

        return true;
    }

    return false;
}

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

        $email = trim((string) $request->input('email'));
        $password = $request->input('password');
        $throttleKey = Str::lower($email) . '|' . $request->ip();


        // Find user with role
        $user = User::with('Role')->where('email', Str::lower($email))->first()
            ?? User::with('Role')->whereRaw('LOWER(email) = ?', [Str::lower($email)])->first();


        if (! $user || ! $this->passwordMatches($user, $password)) {
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
            [$user->Role->role_name ?? 'user']
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data'    => [
                'user' => $this->formatUser($user),
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
            'password'  => $request->input('password'),
            'role_id'   => $request->input('role_id'), // null or provided
        ]);

        $user->load('Role');

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data'    => [
                'user' => $this->formatUser($user),
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
                'user' => $this->formatUser($user),
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
            [$user->Role->role_name ?? 'user']
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

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $user->password = $request->input('password');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }
}
