<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function loginPage(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $loginRequest): RedirectResponse
    {
        if ($loginRequest->login($loginRequest->validated())) {
            $loginRequest->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => __('auth.failed')
        ]);
    }

    public function logout(LogoutRequest $logoutRequest): RedirectResponse
    {
        $logoutRequest->logout();
        $logoutRequest->session()->invalidate();
        $logoutRequest->session()->regenerateToken();
        return redirect()->route('login');
    }
}
