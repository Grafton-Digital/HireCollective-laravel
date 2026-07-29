<?php

namespace App\Notifications;

use App\Models\Boutique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class BoutiqueApplicationRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Boutique $boutique, public string $reason) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $prefillData = base64_encode(json_encode([
            'name' => $this->boutique->name,
            'bio' => $this->boutique->description,
            'region' => $this->boutique->county,
            'website' => $this->boutique->website,
            'contact_email' => $this->boutique->contact_email,
            'phone' => $this->boutique->phone,
            'email' => $this->boutique->pending_email,
            'instagram' => $this->boutique->social_links['instagram'] ?? null,
        ]));

        $resubmitUrl = URL::signedRoute('boutique.application.create', ['prefill' => $prefillData]);

        return (new MailMessage)
            ->subject('Boutique Application Update')
            ->greeting("Hello, {$this->boutique->name}")
            ->line('Unfortunately, your boutique application has not been approved at this time.')
            ->line('Reason:')
            ->line($this->reason)
            ->line('Please make the necessary changes and resubmit your application.')
            ->action('Resubmit Application', $resubmitUrl)
            ->line('Thank you for your interest in HireCollective.');
    }
}
