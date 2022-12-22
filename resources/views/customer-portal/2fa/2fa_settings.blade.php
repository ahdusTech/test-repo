@extends('customer-portal.layout.customer')
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
                        <h3 class="card-title">Zwei-Faktor-Authentifizierung</h3>
                    </div>
                    <div class="card-body">
                        @if(!($data['user']->customer_login_security && $data['user']->customer_login_security->google2fa_enable))
                            <p>
                                The two-factor authentication (2FA) increases the access security, because not only your email address and your password, but also an additional 6-digit 2FA one-time password is verified for your identity when you log in. This additional verification of your credentials better protects you from "password pishing" and "brute force password attacks that use stolen credentials or exploit a weak password. weak password. This 2FA one-time password is provided by the free free mobile app "Google Authenticator" every 30 seconds and is only valid for 30 seconds. seconds.

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

                        @if($data['user']->customer_login_security == null)
                            <form class="form-horizontal" method="POST" action="{{ route('customer.generate2faSecret') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Generate a secret key to enable 2FA
                                    </button>
                                </div>
                            </form>
                        @elseif(!$data['user']->customer_login_security->google2fa_enable)
                            1. Please install the "Google Authenticator" APP on your phone and click the "+" button. Then scan the QR code or alternatively enter the following code in the APP: <code>{{ $data['secret'] }}</code><br/>
                            <img src="{{$data['google2fa_url'] }}" alt="">
                            <br/><br/>
                            2. Enter the 6-digit 2FA one-time password from your "Google Authenticator" APP:

                            <br/><br/>
                            <form class="form-horizontal" method="POST" action="{{ route('customer.enable2fa') }}">
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
                        @elseif($data['user']->customer_login_security->google2fa_enable)
                            {{--<div class="alert alert-success">--}}
                            {{--2FA ist derzeit <strong>aktiviert</strong> Auf deinem Konto.--}}
                            {{--</div>--}}
                            <p>Wenn Sie die Zwei-Faktor-Authentifizierung deaktivieren möchten, geben Sie Ihr aktuelles
                                Passwort ein und klicken Sie auf die Schaltfläche „Deaktivieren Sie 2FA“</p>
                            <form class="form-horizontal" method="POST" action="{{ route('customer.disable2fa') }}">
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
