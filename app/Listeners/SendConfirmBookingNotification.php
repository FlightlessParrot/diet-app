<?php

namespace App\Listeners;

use App\Events\BookingConfirmed;
use App\Notifications\ConfirmBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendConfirmBookingNotification
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
    public function handle(BookingConfirmed $event): void
    {
        $booking = $event->booking;
        $user = $booking->user;
        $specialist = $booking->specialist;
        if($user)
        {
            $user->notify(new ConfirmBooking($event->booking));
        }
        
        $specialist->notify(new ConfirmBooking($event->booking));
    }
}
