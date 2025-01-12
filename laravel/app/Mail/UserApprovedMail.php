<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $approvalLink = url("/users/{$this->user->id}/activate/{$this->user->approval_token}");

        return $this->subject('Fiók aktiválás')
                    ->view('emails.approve-user') // Az email sablon fájl
                    ->with([
                        'approvalLink' => $approvalLink,  // Aktiváló link
                    ]);
    }


}
