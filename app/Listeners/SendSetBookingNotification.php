<?php

namespace App\Listeners;

use App\Events\BookingSet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\SetBooking;

class SendSetBookingNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingSet $event): void
    {
        $booking = $event->booking;
        $user = $booking->user()->first();
        $specialist = $event->booking->specialist;
        $user->notify(new SetBooking($event->booking));
        $specialist->notify(new SetBooking($event->booking));
    }
}
