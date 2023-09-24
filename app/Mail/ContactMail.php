<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $message;

    protected string $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $message, string $email)
    {
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mesaj nou')
            ->markdown('emails.contact', [
                'message' => $this->message,
                'email' => $this->email
            ]);
    }
}
