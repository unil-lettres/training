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
        if ($this->getServerVariable('Shib-Identity-Provider')) {
            // Check if the user can be found in the database
            $user = User::where('email', $this->getServerVariable('mail'))
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
            'name' => $this->getServerVariable('givenName').' '.
                $this->getServerVariable('surname'),
            'email' => $this->getServerVariable('mail'),
            'password' => 'shibboleth',
        ]);
    }

    /**
     * Wrapper function to be able to retrieve server variables.
     */
    private function getServerVariable(string $variableName): ?string
    {
        return RequestFacade::server($variableName) ?? RequestFacade::server('REDIRECT_'.$variableName);
    }
}
