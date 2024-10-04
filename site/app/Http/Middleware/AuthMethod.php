<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMethod
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::user()) {
            return redirect('/');
        }

        // Check if the Shibboleth service is configured, and redirect to the Shibboleth login
        if (config('const.shibboleth.hostname') && config('const.shibboleth.contact')) {
            return redirect('/login/aai');
        }

        // Redirect to the Filament login
        return redirect('/admin');
    }
}
