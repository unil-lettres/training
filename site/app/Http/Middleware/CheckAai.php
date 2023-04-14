<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class CheckAai
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
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
     *
     * @return User $user
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
     *
     * @return string|null
     */
    private function getServerVariable(string $variableName)
    {
        $variable = null;

        if (Request::server($variableName)) {
            $variable = Request::server($variableName);
        } elseif (Request::server('REDIRECT_'.$variableName)) {
            $variable = Request::server('REDIRECT_'.$variableName);
        }

        return $variable;
    }
}
