<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected array $users;

    public function __construct()
    {
        $credentials = File::get(base_path('./credentials.json'));
        $this->users = json_decode($credentials, true);
    }

    public function authenticate($username, $password)
    {
        $user = collect($this->users)->firstWhere('username', $username);

        if ($user && Hash::check($password, $user['password'])) {
            session(['user_id' => $user['id']]);
            return $user;
        }

        return null;
    }

    public function user()
    {
        if (session()->has('user_id')) {
            return collect($this->users)->firstWhere('id', session('user_id'));
        }

        return null;
    }

    public function logout()
    {
        session()->forget('user_id');
    }
}

