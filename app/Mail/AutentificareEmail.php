<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutentificareEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    protected string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to Our Application')
            ->markdown('emails.welcome', [
                'user' => $this->user,
                'url' => $this->url
            ]);
    }
}
