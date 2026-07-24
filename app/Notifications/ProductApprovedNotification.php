<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductApprovedNotification extends Notification
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
            ->subject('Your Product Has Been Approved!')
            ->greeting('Great news!')
            ->line("Your product **{$this->product->name}** has been approved and is now live on HireCollective.")
            ->action('View Boutique', url('/boutique/'.$this->product->boutique->slug))
            ->line('Thank you for listing with HireCollective!');
    }
}
