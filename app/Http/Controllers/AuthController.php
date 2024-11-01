<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginForm()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = $this->authService->authenticate($data['username'], $data['password']);

        if ($user) {
            return redirect('/');
        }

        return redirect('/loginForm')->with(['error' => 'Wrong credentials']);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect('/loginForm');
    }

    public function currentUser()
    {
        $user = $this->authService->user();

        return $user;
    }
}
