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

    /**
     * Return the number of requests with the status equal to "new"
     */
    public static function newRequestCount(): int
    {
        return Request::where('status_admin', 'new')->count();
    }

    /**
     * Return the number of requests with the status equal to "pending"
     */
    public static function pendingRequestCount(): int
    {
        return Request::where('status_admin', 'pending')->count();
    }

    /**
     * Return the number of requests with the status different from "resolved"
     */
    public static function unsolvedRequestCount(): int
    {
        return Request::where('status_admin', '!=', 'resolved')->count();
    }

    /**
     * Return the percentage of solved requests
     */
    public static function solvedRequestPercentage(): ?float
    {
        $requests = Request::all();

        if ($requests->isEmpty()) {
            return null;
        }

        $requestsTotal = $requests->count();
        $requestsSolved = Request::where('status_admin', 'resolved')->count();

        return round(($requestsSolved * 100) / $requestsTotal, 2);
    }

    /**
     * Return the string representation of a checkbox value
     */
    public static function checkboxToString($checkbox): string
    {
        return $checkbox ? 'Oui' : 'Non';
    }
}
