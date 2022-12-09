<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOfferMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $emailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailData['mail_from_email'] , $this->emailData['mail_from_name'])
            ->bcc($this->emailData['bcc'])
            ->subject($this->emailData['subject'])
            ->view('emails.inquiry.send_offer')->with($this->emailData );
    }
}
