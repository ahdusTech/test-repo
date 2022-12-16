<?php

namespace App\Mail;

use App\Models\Admin\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Otpsend extends Mailable
{
    use Queueable, SerializesModels;
    public $userData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(EmailTemplate::find(5)->sender_email, EmailTemplate::find(5)->sender_name)->view('emails.otp.UserRegistrationVerificationCodeMail')->subject(EmailTemplate::find(5)->email_subject);
    }
}
