<?php

namespace Tests\Browser;

use Tests\Browser\Pages\CreateRequest;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class RequestTest extends DuskTestCase
{
    use ProvidesBrowser;

    public function tearDown(): void
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

            $browser->clickLink("Mes demandes")
                ->assertPathIs('/request')
                ->assertSee('Liste des demandes envoyées')
                ->assertSee($name)
                ->assertSee($description);
        });
    }

    /**
     * Create a new researcher request.
     *
     * @return void
     */
    public function testCreateResearcherRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit(new CreateRequest())
                ->selectRequestType('Chercheur/Doctorant');

            $browser->assertSee('Formation demandée')
                ->assertSee('École doctorale')
                ->assertDontSee('Avec un ou des étudiants');

            $name = 'Test Researcher Request';
            $description = 'Test Researcher Description';
            $doctoral_school = 'A Doctoral School';

            $browser->type('name', $name)
                ->type('description', $description)
                ->type('doctoral_school', $doctoral_school)
                ->press('Envoyer');

            $browser->assertPathIs('/')
                ->assertSee('Demande de formation enregistrée.');

            $browser->clickLink("Mes demandes")
                ->assertPathIs('/request')
                ->assertSee('Liste des demandes envoyées')
                ->assertSee($name)
                ->assertSee($description);
        });
    }

    /**
     * Create a new teacher request.
     *
     * @return void
     */
    public function testCreateTeacherRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit(new CreateRequest())
                ->selectRequestType('Enseignant');

            $browser->assertSee('Formation demandée')
                ->assertSee('Avec un ou des étudiants')
                ->assertDontSee('École doctorale');

            $name = 'Test Teacher Request';
            $description = 'Test Teacher Description';

            $browser->type('name', $name)
                ->type('description', $description)
                ->check('students_nbr')
                ->press('Envoyer');

            $browser->assertPathIs('/')
                ->assertSee('Demande de formation enregistrée.');

            $browser->clickLink("Mes demandes")
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

            $browser->clickLink("Nouvelle demande");

            $browser->assertPathIsNot('/request/create')
                ->assertDontSee('Déposer votre demande en tant que')
                ->assertPathIs('/');
        });
    }
}
