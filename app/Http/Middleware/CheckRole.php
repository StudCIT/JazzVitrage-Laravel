<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role == $role || $request->user()->role == 'superAdmin') {
            return $next($request);
        } else {
            return redirect('admin');
        }
    }
}
