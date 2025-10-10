<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Log the user out of the application.
     */
    public function logout(): Response
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()
            ->route('home');
    }
}
