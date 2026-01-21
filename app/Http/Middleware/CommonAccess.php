<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CommonAccess
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
        $roles = [1, 2];
        if (in_array(auth()->user()->role_id, $roles)) {
            return $next($request);
        }
        return redirect('admin/dashboard');
    }
}
