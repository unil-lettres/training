<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function tearDown(): void
    {
        parent::tearDown();
        static::closeAll();
    }

    /**
     * Browse homepage as guest
     *
     * @return void
     */
    public function testHomepageAsGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Demandes de formation')
                ->assertSee('Connexion')
                ->assertDontSee('Mes demandes')
                ->assertDontSee('Déconnexion')
                ->assertDontSee('Administration');
        });
    }

    /**
     * Browse homepage as user
     *
     * @return void
     */
    public function testHomepageAsUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit('/')
                ->assertSee('Demandes de formation')
                ->assertSee('Déconnexion')
                ->assertSee('Mes demandes')
                ->assertDontSee('Connexion')
                ->assertDontSee('Administration');
        });
    }

    /**
     * Browse homepage as admin
     *
     * @return void
     */
    public function testHomepageAsAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('first-user@example.com', 'password');

            $browser->visit('/')
                ->assertSee('Demandes de formation')
                ->assertSee('Déconnexion')
                ->assertSee('Mes demandes')
                ->assertSee('Administration')
                ->assertDontSee('Connexion');
        });
    }
}
