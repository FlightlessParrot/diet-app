<?php

namespace App\Listeners;

use App\Events\PaymentRejected;
use App\Notifications\PaymentRejected as NotificationsPaymentRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentRejectedNotification
{
    
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentRejected $event): void
    {
        $event->specialist->notify(new NotificationsPaymentRejected($event->payment));
    }
}
