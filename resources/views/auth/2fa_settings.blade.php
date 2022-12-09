@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        {{--<strong>--}}Zwei-Faktor-Authentifizierung{{--</strong>--}}
                    </div>
                    <div class="card-body">
                        @if(!($data['user']->loginSecurity && $data['user']->loginSecurity->google2fa_enable))
                            <p>
                                Die Zwei-Faktor-Authentifizierung (2FA) erhöht die Zugriffssicherheit, da nicht nur Ihre E-Mailadresse und Ihr Passwort sondern auch noch zusätzlich ein 6 stelliges 2FA Einmal-Passwort für Ihre Identität bei der Anmeldung überprüft wird. Diese zusätzliche Überprüfung Ihrer Anmeldedaten schützt Sie besser vor „Password Pishing“ und „Brute Force“ Passwort Angriffen, die gestohlene Anmeldeinformationen verwenden oder ein zu schwaches Passwort ausnutzen. Dieses 2FA Einmal-Passwort wird von der kostenlosen Handy-APP „Google Authenticator“ alle 30 Sekunden neu erstellt und ist immer nur 30 Sekunden gültig.
                            </p>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($data['user']->loginSecurity == null)
                            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Generieren Sie einen geheimen Schlüssel, um 2FA zu aktivieren
                                    </button>
                                </div>
                            </form>
                        @elseif(!$data['user']->loginSecurity->google2fa_enable)
                            1. Bitte installieren Sie die „Google Authenticator“ APP auf Ihrem Handy und klicken den „+“
                            Button. Anschließend scannen Sie den QR-Code oder geben Sie alternativ den folgenden Code in
                            der APP ein: <code>{{ $data['secret'] }}</code><br/>
                            <img src="{{$data['google2fa_url'] }}" alt="">
                            <br/><br/>
                            2. Geben Sie das 6 stellige 2FA Einmal-Passwort von Ihrer „Google Authenticator“ APP ein:
                            <br/><br/>
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="secret" class="control-label">2FA Einmal-Passwort</label>
                                    <input autofocus autocomplete="code" id="secret" type="text" class="form-control col-md-4"
                                           name="secret"
                                           autocomplete="off"
                                           required>
                                    @if ($errors->has('verify-code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('verify-code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    2FA aktivieren
                                </button>
                            </form>
                        @elseif($data['user']->loginSecurity->google2fa_enable)
                            {{--<div class="alert alert-success">--}}
                            {{--2FA ist derzeit <strong>aktiviert</strong> Auf deinem Konto.--}}
                            {{--</div>--}}
                            <p>Wenn Sie die Zwei-Faktor-Authentifizierung deaktivieren möchten, geben Sie Ihr aktuelles
                                Passwort ein und klicken Sie auf die Schaltfläche „Deaktivieren Sie 2FA“</p>
                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="control-label">Aktuelles Passwort</label>
                                    <input autofocus autocomplete="current-password" id="current-password" type="password"
                                           class="form-control col-md-4"
                                           name="current-password" autocomplete="off" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary ">2FA deaktivieren</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
