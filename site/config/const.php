<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application constants
    |--------------------------------------------------------------------------
    */

    'app_url' => env('APP_URL', 'http://training.lan:8686'),

    'codespace_name' => env('CODESPACE_NAME'),

    /*
     * Hosts the application accepts, on top of the APP_URL host & its subdomains
     * which the TrustHosts middleware trusts on its own. Plain host names are
     * expected: the anchored pattern the middleware needs is built here, so that
     * a deployment cannot forget the anchors and widen the match.
     */
    'trusted_hosts' => array_values(array_map(
        fn (string $host) => '^'.preg_quote($host).'$',
        array_filter(array_map('trim', explode(',', (string) env('TRUSTED_HOSTS', 'localhost'))))
    )),

    'shibboleth_auth_enabled' => env('SHIBBOLETH_AUTH_ENABLED', false),
];
