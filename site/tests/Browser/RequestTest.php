<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class RequestTest extends DuskTestCase
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
     * Cannot create a new request as guest.
     */
    public function testGuestCannotCreateRequest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/');

            $browser->clickLink('Nouvelle demande');

            $browser->assertPathIsNot('/request/create')
                ->assertDontSee('Déposer votre demande en tant que')
                ->assertPathIs('/');
        });
    }

    /**
     * Create a new invalid request.
     */
    public function testInvalidRequest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord')
                ->visit('/request/create');

            $browser->click('@request-type')
                ->clickLink('Étudiant');

            $browser->press('Envoyer');

            $browser->assertPathIs('/request/create')
                ->assertSee('Le champ nom est requis.');
        });
    }

    /**
     * Create a new student request.
     */
    public function testCreateStudentRequest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord')
                ->visit('/request/create')
                ->click('@request-type')
                ->clickLink('Étudiant');

            $browser->assertSee('Formation demandée')
                ->assertDontSee('École doctorale')
                ->assertDontSee('Avec un ou des étudiants');

            $name = 'Test Student Request';
            $description = 'Test Student Description';

            $browser->type('name', $name)
                ->type('description', $description)
                ->press('Envoyer');

            $browser->assertPathIs('/')
                ->assertSee('Demande de formation enregistrée.');

            $browser->clickLink('Mes demandes')
                ->assertPathIs('/request')
                ->assertSee('Liste des demandes envoyées')
                ->assertSee($name)
                ->assertSee($description);
        });
    }
}
