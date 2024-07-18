<?php

namespace App\Listeners;

use App\Events\SpecialistActivated;
use App\Notifications\ActivateSpecialist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendActivateSpecialistNotification
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
    public function handle(SpecialistActivated $event): void
    {
        $event->specialist->notify(new ActivateSpecialist());
    }
}
