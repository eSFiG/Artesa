<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    protected Collection $users;

    public function __construct()
    {
        $credentials = File::get(base_path('./credentials.json'));
        $data = json_decode($credentials, true);
        $this->users = collect($data);
    }

    public function authenticate($username, $password): ?array
    {
        $user = $this->users->firstWhere('username', $username);

        if ($user && Hash::check($password, $user['password'])) {
            session(['user_id' => $user['id']]);

            $apiToken = Str::random(60);
            $this->updateUserToken($user['id'], $apiToken);

            return $user;
        }

        return null;
    }

    public function user(): ?array
    {
        if (session()->has('user_id')) {
            return collect($this->users)->firstWhere('id', session('user_id'));
        }

        return null;
    }

    protected function updateUserToken($userId, $newToken): void
    {
        $this->users = $this->users->map(function ($user) use ($userId, $newToken) {
            if ($user['id'] === $userId) {
                $user['apiToken'] = $newToken;
            }
            return $user;
        });

        File::put(
            base_path('./credentials.json'),
            json_encode($this->users->toArray(), JSON_PRETTY_PRINT)
        );
    }

    public function validateApiToken($token): bool
    {
        return $this->users->contains(fn ($user) => $user['apiToken'] === $token);
    }

    public function logout(): void
    {
        $userId = session('user_id');
        if ($userId) {
            $this->updateUserToken($userId, '');
        }

        session()->forget('user_id');
    }
}
