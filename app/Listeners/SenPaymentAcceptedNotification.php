<?php

namespace App\Listeners;

use App\Events\PaymentAccepted;
use App\Notifications\PaymentAccepted as NotificationsPaymentAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SenPaymentAcceptedNotification
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
    public function handle(PaymentAccepted $event): void
    {
        $event->specialist->notify(new NotificationsPaymentAccepted($event->payment));
    }
}
