<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use ProvidesBrowser;

    public function tearDown(): void
    {
        parent::tearDown();
        static::closeAll();
    }

    /**
     * Browse administration as user
     *
     * @return void
     */
    public function testAdministrationAsUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('second-user@example.com', 'password');

            $browser->visit('/admin/dashboard')
                ->waitForText('Access denied')
                ->assertSee('Access denied')
                ->assertDontSee('Gérer les utilisateurs');
        });
    }

    /**
     * Browse administration as admin
     *
     * @return void
     */
    public function testAdministrationAsAdmin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->visit('/admin/dashboard')
                ->waitForText('Bonjour First user')
                ->assertSee('Bonjour First user')
                ->assertSee('Gérer les utilisateurs')
                ->assertDontSee('Access denied');
        });
    }

    /**
     * Browse administration users as admin
     *
     * @return void
     */
    public function testAdministrationUsers()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->assertSee('Gérer les utilisateurs')
                ->clickLink('Gérer les utilisateurs')
                ->waitForText('first-user@example.com')
                ->assertSee('first-user@example.com')
                ->assertSee('second-user@example.com');
        });
    }

    /**
     * Create a request in the administration as an admin
     *
     * @return void
     */
    public function testAdministrationCreateRequest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->assertSee('Demandes')
                ->click('@requests-link')
                ->waitForText('Aucune donnée à afficher')
                ->assertSee('Aucune donnée à afficher')
                ->clickLink('Ajouter demande')
                ->assertPathIs('/admin/request/create');

            $name = 'Test create request';

            $browser->type('name', $name)
                ->press('Enregistrer et retour');

            $browser->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucune donnée à afficher')
                ->assertPathIs('/admin/request');
        });
    }

    /**
     * Create a training in the administration as an admin
     *
     * @return void
     */
    public function testAdministrationCreateTraining()
    {
        // Used to fill hidden inputs
        Browser::macro('hidden', function ($name, $value) {
            $this->script("document.getElementsByName('$name')[0].value = '$value'");

            return $this;
        });

        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->assertSee('Formations')
                ->click('@trainings-link')
                ->waitForText('Aucune donnée à afficher')
                ->assertSee('Aucune donnée à afficher')
                ->clickLink('Ajouter formation')
                ->assertPathIs('/admin/training/create');

            $name = 'Test create training';

            $browser->type('name', $name)
                ->hidden('visible', 1)
                ->press('Enregistrer et retour');

            $browser->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucune donnée à afficher')
                ->assertPathIs('/admin/training');

            $browser->visit('/')
                ->assertSee('Pas de formation en groupe annoncée pour l\'instant')
                ->assertDontSee($name);
        });
    }

    /**
     * Create a category in the administration as an admin
     *
     * @return void
     */
    public function testAdministrationCreateCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->visit('/admin/category')
                ->assertSee('Ajouter catégorie')
                ->clickLink('Ajouter catégorie')
                ->assertPathIs('/admin/category/create');

            $name = 'Test create category';

            $browser->type('name', $name)
                ->press('Enregistrer et retour')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucune donnée à afficher')
                ->assertPathIs('/admin/category');
        });
    }

    /**
     * Create a status in the administration as an admin
     *
     * @return void
     */
    public function testAdministrationCreateStatus()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
                ->loginAsUser('first-user@example.com', 'password');

            $browser->visit('/admin/status')
                ->assertSee('Ajouter décision')
                ->clickLink('Ajouter décision')
                ->assertPathIs('/admin/status/create');

            $name = 'Test create status';

            $browser->type('name', $name)
                ->press('Enregistrer et retour')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucune donnée à afficher')
                ->assertPathIs('/admin/status');
        });
    }
}
