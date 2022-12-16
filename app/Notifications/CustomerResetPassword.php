<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerResetPassword extends Notification
{
    use Queueable;

    public $token;
    public $emailHash;

    public function __construct($token, $emailHash)
    {
        $this->token = $token;
        $this->emailHash = $emailHash;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hallo!')
            ->subject('Adomino.net Passwort zurücksetzen')
            ->line('Sie erhalten dieses E-Mail da wir einen Antrag auf Zurücksetzung Ihres Passwortes auf Adomino.net erhalten haben.')
            ->line('Drücken Sie diesen Link um das Passwort zurückzusetzen. Dieser Link ist nur 60 Minuten gültig.')
            ->action('Passwort zurücksetzen', route('customer.password.reset.form', [$this->token, $this->emailHash]))
            /*->line('')*/
            ->line('Falls Sie die Passwort Zurücksetzung nicht beantragt haben, brauchen Sie nichts weiter zu tun.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
