<?php

namespace Tests\Browser;

use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
                ->assertSee('first-user@example.com')
                ->assertSee('second-user@example.com');
        });
    }
}
