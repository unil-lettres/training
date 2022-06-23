<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Login extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admin';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Login as a specific user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $login
     * @param  string  $password
     *
     * @return void
     */
    public function loginAsUser(Browser $browser, $login, $password)
    {
        $browser->type('email', $login)
          ->type('password', $password)
          ->press('Connexion');
    }
}
