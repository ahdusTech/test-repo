<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable implements ShouldQueue
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
        $mail = $this->from($this->emailData['mail_from'], $this->emailData['mail_from_name'])
            ->bcc($this->emailData['bcc'])
            ->subject($this->emailData['subject']);
            if ($this->emailData['attachment']) {
                $mail->attach(public_path() . '/' .str_replace('public/', 'storage/', $this->emailData['attachment']), ['as' => $this->emailData['file_name'], 'mime' => 'application/file']);
            }
        return $mail->view('emails.inquiry.send_offer')->with($this->emailData );
    }
}
