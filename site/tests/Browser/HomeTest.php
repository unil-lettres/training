<?php

namespace Tests\Browser;

use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends DuskTestCase
{
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
            $browser->visit(new Login())
              ->loginAsUser('user', 'user');

            $browser->visit('/')
              ->assertSee('Demandes de formation')
              ->assertSee('Déconnexion')
              ->assertSee('Mes demandes')
              ->assertDontSee('Connexion')
              ->assertDontSee('Administration');
        });
    }
}
