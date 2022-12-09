{{--<p>Bitte geben Sie den PIN-Code ein um die Registrierung abzuschließen.</p>
<p>PIN-Code: {{ $userData['code'] }}</p>
<p>Der PIN-Code ist nur 10 Minuten gültig.</p>--}}

{!! str_replace(['[[anrede-nachname]]','[[pin-code]]'] , [$userData['name'], $userData['code']] , \App\Models\Admin\EmailTemplate::find(5)->email_text) !!}

