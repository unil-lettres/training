<?php

namespace App\Helpers;

use App\Models\Request;

class Helpers {
    /**
     * Return a human readable status
     *
     * @param array $status
     *
     * @return string $status
     */
    public static function requestStatus($status) {
        $status = collect(Request::$status)->pull($status);

        if(is_string($status)) {
            return $status;
        }

        return '-';
    }
}
