<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register the Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
        // Macro used in dusk tests to fill hidden inputs
        Browser::macro('hidden', function ($name, $value) {
            $this->script("document.getElementsByName('$name')[0].value = '$value'");

            return $this;
        });
    }
}
