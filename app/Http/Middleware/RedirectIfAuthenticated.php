<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle($request, Closure $next)
    {
        if ($this->authService->user()) {
            if ($request->is('loginForm') || $request->is('login')) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
