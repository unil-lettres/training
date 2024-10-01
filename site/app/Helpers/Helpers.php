<?php

namespace App\Helpers;

use App\Models\Request;

class Helpers
{
    /**
     * Return a human readable status
     */
    public static function requestStatus(?string $status): string
    {
        $status = collect(Request::$status)->pull($status);

        if (is_string($status)) {
            return $status;
        }

        return '-';
    }
}
