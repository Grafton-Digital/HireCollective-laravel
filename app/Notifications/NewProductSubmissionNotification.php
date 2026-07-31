<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProductSubmissionNotification extends Notification
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
            ->subject('New Product Submission: '.$this->product->name)
            ->greeting('New Product Submitted')
            ->line("A new product \"{$this->product->name}\" has been submitted by {$this->product->boutique->name} for review.")
            ->line('Designer: '.($this->product->designer ?? 'N/A'))
            ->line('Price per day: €'.number_format((float) $this->product->price_per_day, 2))
            ->action('Review Product', url('/admin/product-enquiries'))
            ->line('Please review and approve or reject this product.');
    }
}
