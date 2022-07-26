<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateRequest extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/request/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Select request type.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $type
     * @return void
     */
    public function selectRequestType(Browser $browser, $type)
    {
        $browser->click('@request-type')
          ->clickLink($type);
    }
}
