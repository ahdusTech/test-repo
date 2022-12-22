@extends('layouts.auth')
@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>
            <div class="card-body">


                <p class="login-box-msg" style="margin-bottom: 5px">Anmeldung</p>
                Geben Sie das 2FA Einmal-Passwort von Ihrer „Google Authenticator“ APP ein:<br/><br/>
                <form class="form-horizontal"  action="{{ auth()->guard('customer')->user() ? route('customer.2faVerify') : route('2faVerify') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="input-group mb-3">
                        <input type="text" id="one_time_password" name="one_time_password"
                               autocomplete="new-one_time_password" autofocus
                               class="form-control @if(isset($errors->all()[0])) is-invalid @endif">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if(isset($errors->all()[0]))
                            <span class="error invalid-feedback" role="alert">
                            <strong>Geben Sie bitte das richtige 2FA Passwort ein.</strong>
                    </span>
                        @endif
                    </div>
                    <button class="btn btn-primary" style="width: 100%" type="submit">Anmelden</button>
                </form>
            </div>
        </div>
    </div>

@endsection
