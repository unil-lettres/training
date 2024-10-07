<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\ProvidesBrowser;
use Tests\DuskTestCase;

class RequestTest extends DuskTestCase
{
    use ProvidesBrowser;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        static::closeAll();
    }

    /**
     * Cannot create a new request as guest. Redirect to Filament login page.
     */
    public function testGuestCannotCreateRequest(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/');

            $browser->clickLink('Nouvelle demande');

            $browser->assertSee('Connectez-vous à votre compte')
                ->assertPathIsNot('/request/create')
                ->assertPathIs('/admin/login');
        });
    }
}
