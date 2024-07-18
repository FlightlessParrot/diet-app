<?php

namespace App\Listeners;

use App\Events\BookingDeleted;
use App\Notifications\DeleteBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeleteBookingNotification
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
    public function handle(BookingDeleted $event): void
    {
        $user = $event->booking->user;
        $specialist = $event->booking->specialist;

        if($user)
        {
        $user->notify(new DeleteBooking($event->booking));
        }
        
        $specialist->notify(new DeleteBooking($event->booking));
    }
}
