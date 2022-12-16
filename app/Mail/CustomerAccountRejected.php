<?php

namespace App\Mail;

use App\Models\Admin\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerAccountRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    /*->subject('Adomino.net Zertifizierung Level 4 Antrag')*/
                    ->subject(EmailTemplate::find(7)->email_subject)
                    ->view('emails.certificate_levels.account_rejected');
    }
}
