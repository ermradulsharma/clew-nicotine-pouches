<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AgeRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->get('age_verified', false)) {
            $request->session()->put('url.intended', $request->fullUrl());
            return redirect()->route('ageRestriction');
        }
        return $next($request);
    }
}
