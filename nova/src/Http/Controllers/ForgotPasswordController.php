<?php

namespace Laravel\Nova\Http\Controllers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use ValidatesRequests;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('nova.guest:'.config('nova.guard'));

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
                ->subject(__('Adomino.net Passwort zurücksetzen'))
                ->line(__('Sie erhalten dieses E-Mail da wir einen Antrag auf Zurücksetzung Ihres Passwortes auf Adomino.net erhalten haben.'))
                ->action(__('Passwort zurücksetzen'), url(config('nova.url').route('nova.password.reset', $token, false)))
                ->line(__('Falls Sie die Passwort Zurücksetzung nicht beantragt haben, brauchen Sie nichts weiter zu tun.'));
        });
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('nova::auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker(config('nova.passwords'));
    }
}
