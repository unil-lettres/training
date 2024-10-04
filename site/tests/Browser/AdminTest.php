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
                ->assertDontSee('Ces identifiants ne correspondent pas à nos enregistrements');
        });
    }

    /**
     * Browse administration users as admin
     */
    public function testAdministrationUsers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->loginAsUser('admin-user@example.com', 'password');

            $browser->waitForText('Tableau de bord')
                ->visit('/admin/users')
                ->waitForText('admin-user@example.com')
                ->assertSee('admin-user@example.com')
                ->assertSee('second-user@example.com');
        });
    }
}
