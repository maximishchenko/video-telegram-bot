<?php

namespace App\Mail\Auth\Register;

use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->subject(trans('messages.email_signup_confirmation'))
            ->markdown('mails.auth.register.confirm');
    }
}
