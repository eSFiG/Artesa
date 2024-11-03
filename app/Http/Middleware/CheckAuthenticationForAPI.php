<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Support\Str;

class CheckAuthenticationForAPI
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle($request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader && Str::startsWith($authorizationHeader, 'Bearer ')) {
            $token = Str::after($authorizationHeader, 'Bearer ');

            if ($this->authService->validateApiToken($token)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
