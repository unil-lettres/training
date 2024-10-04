<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('cache:clear'); // Avoid rate limiting issue
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
}
