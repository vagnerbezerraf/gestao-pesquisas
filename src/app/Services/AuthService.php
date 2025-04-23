<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register user for web.
     */
    public function registerWeb(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * Attempt login for web.
     */
    public function loginWeb(array $credentials, bool $remember = false): bool
    {
        return Auth::guard('web')->attempt($credentials, $remember);
    }

    /**
     * Logout for web.
     */
    public function logoutWeb(): void
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
