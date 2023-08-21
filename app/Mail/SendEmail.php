<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data_email;
    /**
     * Create a new message instance.
     */
    public function __construct($data_email)
    {
        $this->data_email = $data_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data_email['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->data_email['type'] == "otpRegister") {
            return new Content(
                view: 'mail.sendEmail',
            );
        } elseif ($this->data_email['type'] == "payment") {
            return new Content(
                view: 'mail.sendPayment',
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
