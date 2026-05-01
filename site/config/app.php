<?php

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Redis;

return [

    'aliases' => Facade::defaultAliases()->merge([
        'Helpers' => Helpers::class,
        'Redis' => Redis::class,
    ])->toArray(),

];
