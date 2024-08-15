<?php

namespace   App\Supports\DayClerk;

use App\Enums\DaysOfWeek;
use App\Supports\FindBookings\FindBookingInterface;
use Illuminate\Support\Collection;

interface DayClerkInterface
{
     /**
     * Return a collection of start and end date for a day
     * @return void
     */
    public function getByDayOfWeek(DaysOfWeek $daysOfWeek) : Collection;

    public function getAllDates() : Collection;

    public function __construct(string $startDate, string $endDate, FindBookingInterface $findBookings);
}