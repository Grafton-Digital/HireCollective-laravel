<?php

namespace App\Notifications;

use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoutiqueApplicationRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Boutique $boutique) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Boutique Application Update')
            ->greeting("Hello, {$this->boutique->name}")
            ->line('Unfortunately, your boutique application has not been approved at this time.')
            ->line('If you believe this was a mistake or would like more information, please contact us.')
            ->action('Contact Support', url('/'))
            ->line('Thank you for your interest in HireCollective.');
    }
}
