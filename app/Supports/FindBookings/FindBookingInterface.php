<?php

namespace App\Supports\FindBookings;

use Illuminate\Support\Collection;

interface FindBookingInterface
{
     /**
     * Find by unix days
     * 
     * @param string $startDate
     * mysql date format start date
     * 
     * @param string $endDate
     * mysql date format end date
     */
    public function byDays(string $startDate, string $endDate) :Collection;
}