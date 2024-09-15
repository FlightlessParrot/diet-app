<?php

namespace App\Listeners;

use App\Events\BookingIsComming;
use App\Notifications\BookingIsCommingNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendBookingNotyfication
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
    public function handle(BookingIsComming $event): void
    {
        $booking=$event->booking;
        $user = $booking->user()->first();
        $user->notify(new BookingIsCommingNotification($event->booking));
        $date=new \DateTime($booking->start_date);
        $response = Http::withToken(env('SMS_TOKEN'))->post('https://api.smsapi.pl/sms.do',
        [
            'to'=>$user->phone->number,
            'message'=>'Przypominamy o spotkaniu z dietetykiem dnia '.$date->format('d-m-Y')
            .' o godzinie '.$date->format('h:i')
        ]);
    }
}
