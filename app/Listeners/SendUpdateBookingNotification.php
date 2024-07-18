<?php

namespace App\Listeners;

use App\Events\BookingUpdated;
use App\Notifications\UpdateBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUpdateBookingNotification
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
    public function handle(BookingUpdated $event): void
    {
        $user = $event->booking->user;
        $specialist = $event->booking->specialist;
        if($user)
        {
            $user->notify(new UpdateBooking($event->booking));
            $specialist->notify(new UpdateBooking($event->booking));
        }
        
        
    }
}
