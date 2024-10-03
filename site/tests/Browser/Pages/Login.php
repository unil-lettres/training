<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Login extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/admin';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void {}

    /**
     * Get the element shortcuts for the page.
     */
    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Login as a specific user.
     */
    public function loginAsUser(Browser $browser, string $login, string $password): void
    {
        $browser->type('input[type=email]', $login)
            ->type('input[type=password]', $password)
            ->pause(5000) // Avoid issues in GitHub Actions
            ->click('button[type=submit]'); // Connexion button
    }
}
