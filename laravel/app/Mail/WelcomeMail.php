<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $activationLink = route('activate.account', ['token' => $this->user->activation_token]);

        return $this->subject('Üdvözlünk a platformon!')
                    ->view('emails.welcome', compact('activationLink'));
    }
}

