<?php

namespace App\Providers;

use App\Models\Request;
use App\Observers\RequestObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the observers
        Request::observe(RequestObserver::class);

        // Fix migration error
        Schema::defaultStringLength(191);

        // Use bootstrap as default css framework for paginator
        Paginator::useBootstrap();

        /**
         * This is a workaround for proxies/reverse proxies that don't always pass the proper headers.
         *
         * Here, we check if the APP_URL starts with https://, which we should always honor,
         * regardless of how well the proxy or network is configured.
         */
        if ((str_starts_with(config('const.app_url'), 'https://'))) {
            URL::forceScheme('https');
        }
    }
}
