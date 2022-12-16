<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerDocumentApprovelEmail extends Mailable implements ShouldQueue
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
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Adomino Zertifizierung Level 4 Antrag')
            ->view('emails.certificate_levels.account_approvel')
            ->with([
                'id' => $this->emailData['id'],
                'url' => $this->emailData['url'],
            ]);
    }
}
