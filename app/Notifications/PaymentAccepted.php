<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentAccepted extends Notification
{
    use Queueable;
    
    protected $subscription;
    /**
     * Create a new notification instance.
     */
    public function __construct(public Payment $payment)
    {
        $this->subscription=$payment->subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'line_1'=> 'Twoja platnosc z dnia '.$this->payment->created_at.' zostala zaakceptowana.',
            'line_2' => 'Utworzona subskrypcja konczy sie dnia '.$this->subscription->end_date.'.'
        ];
    }
}
