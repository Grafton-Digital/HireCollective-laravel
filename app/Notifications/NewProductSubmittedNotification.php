<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductSubmittedNotification extends Notification
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
            ->subject('New Product Submitted: '.$this->product->name)
            ->greeting('New product awaiting approval!')
            ->line("**{$this->product->name}** has been submitted by {$this->product->boutique->name}.")
            ->line("Designer: {$this->product->designer}")
            ->line("Region: {$this->product->county?->value}")
            ->action('Review Product', url('/admin/product-enquiries'))
            ->line('Please review and approve or reject this product.');
    }
}
