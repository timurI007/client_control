<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService
{
    public function login(Request $request, array $credentials): bool
    {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return true;
        }
        return false;
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function getUserFullName(): ?string
    {
        $user = Auth::user();
        return $user ? $user->name . ' ' . $user->lastname : null;
    }
}