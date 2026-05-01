<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application constants
    |--------------------------------------------------------------------------
    */

    'app_url' => env('APP_URL', 'http://training.lan:8686'),

    'codespace_name' => env('CODESPACE_NAME'),

    'shibboleth' => [
        'hostname' => env('SHIB_HOSTNAME', null),
        'contact' => env('SHIB_CONTACT', null),
    ],

];
