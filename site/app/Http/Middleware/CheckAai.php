<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as RequestFacade;
use Symfony\Component\HttpFoundation\Response;

class CheckAai
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

        // Check if the user is authenticated by SwitchAAI
        if ($this->getShibbolethHeader('X-Shib-Identity-Provider')) {
            // Check if the user can be found in the database
            $user = User::where('email', $this->getShibbolethHeader('X-Shib-Mail'))
                ->first();

            if (! $user) {
                // If the user cannot be found, create it
                $user = $this->createAaiUser();
            }

            // Log the user
            Auth::login($user, true);

            return Redirect::intended('/');
        }

        // Return to the app root with error message otherwise
        return redirect('/')
            ->with('error', trans('auth.aai_failed'));
    }

    /**
     * Create a new aai user.
     */
    private function createAaiUser(): User
    {
        return User::create([
            'name' => $this->getShibbolethHeader('X-Shib-GivenName').' '.
                $this->getShibbolethHeader('X-Shib-Surname'),
            'email' => $this->getShibbolethHeader('X-Shib-Mail'),
            'password' => 'shibboleth',
        ]);
    }

    /**
     * Retrieve an attribute forwarded by the Shibboleth proxy.
     *
     * Only trust headers specified in SHIB_SESSION_PROPERTIES and SHIB_ATTRIBUTES.
     */
    private function getShibbolethHeader(string $header): ?string
    {
        return RequestFacade::header($header);
    }
}
