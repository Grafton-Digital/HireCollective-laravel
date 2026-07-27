<?php

namespace App\Notifications;

use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBoutiqueApplicationNotification extends Notification
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
            ->subject('New Boutique Application: '.$this->boutique->name)
            ->markdown('emails.new-boutique-application', [
                'boutique' => $this->boutique,
            ]);
    }
}
