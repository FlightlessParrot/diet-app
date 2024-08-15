<?php

namespace App\Supports\FindBookings;

use App\Models\Specialist;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FindBookings implements FindBookingInterface
{
    public function __construct(public Specialist $specialist){}

    /**
     * Find by unix days
     */
    public function byDays(string $startDate, string $endDate) :Collection
    {
        $bookings = $this->specialist->bookings()->where(function (Builder $query)  use ($startDate, $endDate) {
            $query->where('start_date', '>=', $startDate)->where('start_date', '<', $endDate);
        })
            ->orWhere(function (Builder $query) use ($startDate, $endDate) {
                $query->where('end_date', '>', $startDate)->where('end_date', '<=', $endDate);
            })->orWhere(function (Builder $query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $startDate)->where('end_date', '>=', $endDate);
            })->get();

        return $bookings;
    }
}