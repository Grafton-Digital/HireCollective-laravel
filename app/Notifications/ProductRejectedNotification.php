<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Product $product) {}

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
            ->subject('Product Submission Update')
            ->greeting('Hello')
            ->line("Unfortunately, your product **{$this->product->name}** has not been approved at this time.")
            ->line('If you believe this was a mistake or would like more information, please contact us.')
            ->action('My Account', url('/account/overview'))
            ->line('Thank you for your interest in HireCollective.');
    }
}
