<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class LoginThrottle
{
    public function handle($request, Closure $next)
    {
        $username = $request->input('username');
        $ipAddress = $request->ip();
        $throttleKey = strtolower($username) . '|' . $ipAddress;

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {;
            return redirect('/loginForm')
                ->with(['error' => "Too many attempts. Try again in seconds"]);
        }

        $response = $next($request);

        if ($response->getStatusCode() === 302 && $response->headers->get('location') === route('loginForm')) {
            RateLimiter::hit($throttleKey, 300);
        }
        else {
            RateLimiter::clear($throttleKey);
        }

        return $response;
    }
}
