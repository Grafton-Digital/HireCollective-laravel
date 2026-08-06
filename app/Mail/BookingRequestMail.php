<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Booking Request — '.$this->enquiry->product->name,
            replyTo: [$this->enquiry->customer_email],
        );
    }

    public function build(): self
    {
        return $this->markdown('emails.booking-request');
    }
}
