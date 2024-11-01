<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;

class AuthenticateWithFileCredentials
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle($request, Closure $next)
    {
        if (!$this->authService->user()) {
            return redirect('/loginForm');
        }

        return $next($request);
    }
}
