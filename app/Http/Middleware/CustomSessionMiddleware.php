<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current session ID
        $sessionId = $request->session()->getId();

        // Continue the request/response cycle
        $response = $next($request);

        // If the user is authenticated and a new session has been created after login, set the old session ID.
        if (auth()->check() && $request->session()->getId() !== $sessionId) {
            $request->session()->setId($sessionId);
            $request->session()->regenerateToken();
        }

        return $response;
        //return $next($request);
    }
}
