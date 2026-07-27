<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CollaborationEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public ?string $company,
        public string $enquiryMessage,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Collaboration Enquiry from '.$this->name,
            replyTo: [$this->email],
        );
    }

    public function build(): self
    {
        return $this->markdown('emails.collaboration-enquiry');
    }
}
