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
        return collect(Request::$status)->pull($status);
    }
}
