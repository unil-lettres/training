<?php

namespace App\Helpers;

use App\Models\Request;

class Helpers {
    /**
     * Return a human readable status
     *
     * @param string $status
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

    /**
     * Return the number of requests with the status equal to "new"
     *
     * @return int
     */
    public static function newRequestCount() {
        return Request::where('status', 'new')->count();
    }

    /**
     * Return the number of requests with the status equal to "pending"
     *
     * @return int
     */
    public static function pendingRequestCount() {
        return Request::where('status', 'pending')->count();
    }

    /**
     * Return the number of requests with the status different from "resolved"
     *
     * @return int
     */
    public static function unsolvedRequestCount() {
        return Request::where('status', '!=', 'resolved')->count();
    }

    /**
     * Return the percentage of solved requests
     *
     * @return float|null
     */
    public static function solvedRequestPercentage() {
        $requests = Request::all();

        if($requests->isEmpty()) {
            return null;
        }

        $requestsTotal = $requests->count();
        $requestsSolved = Request::where('status', 'resolved')->count();

        return round(($requestsSolved * 100) / $requestsTotal, 2);
    }
}
