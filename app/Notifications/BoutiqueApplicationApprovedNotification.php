<?php

namespace App\Notifications;

use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoutiqueApplicationApprovedNotification extends Notification
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
            ->subject('Your Boutique Has Been Approved!')
            ->greeting("Congratulations, {$this->boutique->name}!")
            ->line('Your boutique application has been approved. You can now log in to your account and start managing your boutique.')
            ->action('Log In', url('/login'))
            ->line('Thank you for joining HireCollective!');
    }
}
