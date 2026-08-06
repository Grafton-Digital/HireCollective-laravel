<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $customerName,
        public string $customerEmail,
        public ?string $customerPhone,
        public string $productName,
        public string $productEditUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Book a Test Request — '.$this->productName,
            replyTo: [$this->customerEmail],
        );
    }

    public function build(): self
    {
        return $this->markdown('emails.book-test');
    }
}
