<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Specialist;

class PaymentAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * Specialist who paid
     * 
     * @var Specialist $specialist
     */
    public $specialist;
    /**
     * Create a new event instance.
     */
    public function __construct(public Payment $payment)
    {
        $this->specialist=$payment->specialist;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
