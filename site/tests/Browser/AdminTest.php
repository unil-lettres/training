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
            $browser->pause(2000)
                ->visit(new Login)
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
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->assertSee('Tableau de bord')
                ->assertDontSee('Ces identifiants ne correspondent pas à nos enregistrements');
        });
    }

    /**
     * Browse administration users as admin
     */
    public function testAdministrationUsers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/admin/users')
                ->waitForText('admin-user@example.com')
                ->assertSee('admin-user@example.com')
                ->assertSee('second-user@example.com');
        });
    }

    /**
     * Create a request in the administration as an admin
     */
    public function testAdministrationCreateRequest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/admin/requests')
                ->waitForText('Aucun élément trouvé')
                ->assertSee('Aucun élément trouvé')
                ->visit('/admin/requests/create');

            $name = 'Test create request';

            $browser->waitForText('Créer Demande')
                ->type('input#data\.name', $name)
                ->pause(2000) // Avoid issue with click
                ->click('button[type=submit]#key-bindings-1'); // Create button

            $browser->waitForText($name)
                ->visit('/admin/requests')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucun élément trouvé');
        });
    }

    /**
     * Create a training in the administration as an admin
     */
    public function testAdministrationCreateTraining(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/admin/trainings')
                ->waitForText('Aucun élément trouvé')
                ->assertSee('Aucun élément trouvé')
                ->visit('/admin/trainings/create');

            $name = 'Test create training';

            $browser->waitForText('Créer Formation')
                ->type('input#data\.name', $name)
                ->pause(2000) // Avoid issue with click
                ->click('button[type=submit]#key-bindings-1'); // Create button

            $browser->waitForText($name)
                ->visit('/admin/trainings')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucun élément trouvé');

            // By default, should not be visible on the homepage
            $browser->visit('/')
                ->assertSee('Pas de formation en groupe annoncée pour l\'instant')
                ->assertDontSee($name);
        });
    }

    /**
     * Create a category in the administration as an admin
     */
    public function testAdministrationCreateCategory(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/admin/categories')
                ->waitForText('Aucun élément trouvé')
                ->assertSee('Aucun élément trouvé')
                ->visit('/admin/categories/create');

            $name = 'Test create category';

            $browser->waitForText('Créer Catégorie')
                ->type('input#data\.name', $name)
                ->pause(2000) // Avoid issue with click
                ->click('button[type=submit]#key-bindings-1'); // Create button

            $browser->waitForText($name)
                ->visit('/admin/categories')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucun élément trouvé');
        });
    }

    /**
     * Create a status in the administration as an admin
     */
    public function testAdministrationCreateStatus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->pause(2000)
                ->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord', 15)
                ->visit('/admin/statuses')
                ->waitForText('Aucun élément trouvé')
                ->assertSee('Aucun élément trouvé')
                ->visit('/admin/statuses/create');

            $name = 'Test create status';

            $browser->waitForText('Créer Décision')
                ->type('input#data\.name', $name)
                ->pause(2000) // Avoid issue with click
                ->click('button[type=submit]#key-bindings-1'); // Create button

            $browser->waitForText($name)
                ->visit('/admin/statuses')
                ->waitForText($name)
                ->assertSee($name)
                ->assertDontSee('Aucun élément trouvé');
        });
    }
}
