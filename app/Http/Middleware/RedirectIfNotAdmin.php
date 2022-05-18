<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfNotAdmin {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
