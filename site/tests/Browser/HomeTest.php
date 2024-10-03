<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('cache:clear'); // Avoid rate limiting issue
        //Artisan::call('migrate:fresh --seed');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        static::closeAll();
    }

    /**
     * Browse homepage as guest
     */
    public function testHomepageAsGuest(): void
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
     * Browse homepage as admin
     */
    public function testHomepageAsAdmin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/')
                ->assertSee('Demandes de formation')
                ->assertSee('Déconnexion')
                ->assertSee('Mes demandes')
                ->assertSee('Administration')
                ->assertDontSee('Connexion');

            $browser->click('@admin')
                ->waitForText('Tableau de bord', 15)
                ->assertSee('Tableau de bord')
                ->assertPathIs('/admin');
        });
    }
}
