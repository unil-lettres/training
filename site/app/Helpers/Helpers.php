<?php

namespace App\Helpers;

use App\Enums\RequestStatusAdmin;

class Helpers
{
    /**
     * Return a human readable status
     */
    public static function requestStatus(?string $status): string
    {
        $status = collect(RequestStatusAdmin::toArray())->pull($status);

        if (is_string($status)) {
            return $status;
        }

        return '-';
    }
}
