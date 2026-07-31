<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Product $product, public string $reason) {}

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
            ->greeting('Hello!')
            ->line("Unfortunately, your product \"{$this->product->name}\" has not been approved at this time.")
            ->line('Reason:')
            ->line($this->reason)
            ->line('Please update your product and resubmit for review.')
            ->action('Edit Product', url("/account/products/{$this->product->id}/edit"))
            ->line('Thank you for your patience.');
    }
}
