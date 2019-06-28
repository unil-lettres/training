<?php

namespace App\Http\Middleware;

use Closure;

class RequireAdminRole
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
        $user = auth()->user();

        if (!$user) return $next($request);

        if (!$user->hasRole('Admin'))
        {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}
