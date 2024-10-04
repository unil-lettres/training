<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('cache:clear'); // Avoid rate limiting issue
    }

    protected function tearDown(): void
    {
        static::closeAll();
        parent::tearDown();
    }

    /**
     * Browse administration as user
     */
    public function testAdministrationAsUser(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('second-user@example.com', 'password');

            $browser->waitForText('Ces identifiants ne correspondent pas à nos enregistrements')
                ->assertSee('Ces identifiants ne correspondent pas à nos enregistrements')
                ->assertDontSee('Tableau de bord');
        });
    }

    /**
     * Browse administration as admin
     */
    public function testAdministrationAsAdmin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord')
                ->assertSee('Tableau de bord')
                ->assertSee('Dernières demandes')
                ->assertSee('Dernières formations')
                ->assertSee('Retourner à l\'application')
                ->assertSee('Demandes')
                ->assertSee('Catégories')
                ->assertSee('Formations')
                ->assertSee('Décisions')
                ->assertSee('Utilisateurs')
                ->assertDontSee('Ces identifiants ne correspondent pas à nos enregistrements');
        });
    }
}
