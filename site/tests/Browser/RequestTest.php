<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\CreateRequest;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class RequestTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function tearDown(): void
    {
        parent::tearDown();
        static::closeAll();
    }

    /**
     * Create a new student request.
     *
     * @return void
     */
    public function testCreateStudentRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit(new CreateRequest())
                ->selectRequestType('Étudiant');

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

    /**
     * Create a new invalid request.
     *
     * @return void
     */
    public function testInvalidRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit(new CreateRequest())
                ->selectRequestType('Étudiant');

            $browser->press('Envoyer');

            $browser->assertPathIs('/request/create')
                ->assertSee('Le champ nom est requis.');
        });
    }

    /**
     * Cannot create a new request as guest.
     *
     * @return void
     */
    public function testGuestCannotCreateRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/');

            $browser->clickLink('Nouvelle demande');

            $browser->assertPathIsNot('/request/create')
                ->assertDontSee('Déposer votre demande en tant que')
                ->assertPathIs('/');
        });
    }
}
