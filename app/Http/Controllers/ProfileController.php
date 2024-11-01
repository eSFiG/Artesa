<?php

namespace App\Http\Controllers;

use App\Services\AuthService;

class ProfileController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function profilePage()
    {
        $user = $this->authService->user();
        return view('profile', ['user' => $user]);
    }
}
