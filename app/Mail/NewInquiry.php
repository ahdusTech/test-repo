<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInquiry extends Mailable
{
    use SerializesModels;

    private $gender, $prename, $surname, $email, $domain, $ip, $recaptchaScore, $language, $dateTime, $selectedLanguage, $subjectPrefix;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gender, $prename, $surname, $email, $domain, $ip, $recaptchaScore, $language, $dateTime, $selectedLanguage, $subjectPrefix = '')
    {
        $this->gender = $gender;
        $this->prename = $prename;
        $this->surname = $surname;
        $this->email = $email;
        $this->domain = $domain;
        $this->ip = $ip;
        $this->recaptchaScore = $recaptchaScore;
        $this->language = $language;
        $this->dateTime = $dateTime;
        $this->selectedLanguage = $selectedLanguage;
        $this->subjectPrefix = $subjectPrefix;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $formatedDateTime = Carbon::parse($this->dateTime, 'UTC')
            ->setTimezone('Europe/Vienna')
            ->toDateTimeString('minute');

        return $this->from(config('mail.from'))
            ->text('emails.inquiry.new')
            ->subject($this->subjectPrefix . "Adomino: Kaufanfrage zu Domain $this->domain")
            ->with([
                'gender' => $this->gender,
                'prename' => $this->prename,
                'surname' => $this->surname,
                'email' => $this->email,
                'domain' => $this->domain,
                'ip' => $this->ip,
                'recaptchaScore' => $this->recaptchaScore,
                'language' => $this->language,
                'dateTime' => $formatedDateTime,
                'selectedLanguage' => $this->selectedLanguage,
            ]);
    }
}
