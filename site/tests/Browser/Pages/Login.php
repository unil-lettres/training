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
     * @return void
     */
    public function assert(Browser $browser) {}

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
     * @param  string  $login
     * @param  string  $password
     * @return void
     */
    public function loginAsUser(Browser $browser, $login, $password)
    {
        $browser->type('input[type=email]', $login)
            ->type('input[type=password]', $password)
            ->pause(2000) // Avoid issues during with GitHub Actions
            ->clickLink('Connexion', 'span.fi-btn-label');
    }
}
