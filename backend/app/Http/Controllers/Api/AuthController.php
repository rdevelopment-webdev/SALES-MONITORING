<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private function passwordMatches(User $user, string $plainPassword): bool
    {
        if (Hash::check($plainPassword, $user->password)) {
            return true;
        }

        if (Hash::check(Hash::make($plainPassword), $user->password)) {
            return true;
        }

        if (hash_equals((string) $user->password, $plainPassword)) {
            $user->forceFill([
                'password' => Hash::make($plainPassword),
            ])->save();

            return true;
        }

        return false;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = trim((string) $request->email);
        $user = User::where('email', $email)->first()
            ?? User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();

        if (! $user || ! $this->passwordMatches($user, $request->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create token (Sanctum) or return user data
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
