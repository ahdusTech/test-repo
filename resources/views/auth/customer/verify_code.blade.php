@extends('customer-portal.layout.auth')

@section('content')
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<script src='https://www.google.com/recaptcha/api.js?render=SITE_KEY' async defer></script>
<script src='https://www.google.com/recaptcha/api.js?render=SECURITY_KEY' async defer></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="login-box">
        <div class="card {{--card-outline--}} card-primary">
            {{--<div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>--}}
            <div class="card-body">
                @if (session($email))
                    <p class="login-box-msg">{{__('auth.registration')}}</p>
                    {{--<p class="login-box-msg">{{__('auth.verification_code')}}</p>--}}
                    @if(session('verification_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session('verification_error')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('customer.register') }}" id="verify_code" autocomplete="off">
                        @csrf
                        @if (session($email))
                            @foreach(session($email) as $key => $val)
                                @if ($key != 'code' or $key != '_token')
                                    <input type="hidden" name="{{$key}}" value="{{$val}}" class="form-control " >
                                @endif
                            @endforeach
                        @endif
                        <div class="input-group ">
                            <p class="text-gray text-sm ">Geben Sie bitte den 6 stelligen PIN-Code ein den wir lhnen auf lhre angegebene E-Mail geschickt haben.</p>
                            <input data-message="Bitte geben Sie in das Feld etwas ein" type="number"   name="code" class="form-control @error('code') is-invalid @enderror"
                                   placeholder="{{__('auth.verification_code')}}" autofocus autocomplete="off" value="{{ old('code') ?? '' }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('code')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p class="text-gray text-sm  mt-4">W채hlen Sie ein Passwort f체r lhren Kundenbereich.</p>
                            <div class=" input-group">
                                <input   autocomplete="off" type="password" data-message="Bitte geben Sie in das Feld etwas ein" name="password" class="form-control @error('password')   is-invalid @enderror"
                                       placeholder="{{__('auth.customer_registration_form_input_password')}}" value="{{ old('password') ?? '' }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input {{--minlength="8"--}} autocomplete="off" type="password" data-message="Bitte geben Sie in das Feld etwas ein" name="password_confirmation" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="{{__('auth.customer_registration_form_input_password_confirm')}}" value="{{ old('password') ?? '' }}" >
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group mt-2">
                            <div class="icheck-primary d-flex">
                                <input type="checkbox" name="agree" class=""   style="margin: 3px 3px auto;@error('agree')  outline:red auto; box-shadow: 0 0 1.5px 1px red; @enderror"
                                       id="agree" {{ old('agree') ? 'checked' : '' }} data-message="Bitte lesen und akzeptieren Sie die AGBs." >
                                <label class="text-xs @error('agree')    text-red @else text-gray @enderror   " for="agree" style="  color: #171819; margin-left: 5px; font-weight: 400;font-size: 15px;">
                                    Ich habe die <a class="@error('agree') text-red @enderror" href="{{route('static.agb')}}"><u>AGB</u></a> gelesen und akzeptiert und erkl채re mich damit einverstanden, dass meine Daten elektronisch verarbeitet und gespeichert werden. Die Daten werden nicht unbefugt an Dritte weitergegeben.
                                </label>

                                {{--@error('agree')
                                <span class="error invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror--}}
                            </div>
                        </div>


                        <p class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block text-bold">Kundenkonto erstellen</button>
                        </p>
                    </form>
                    {{--<p class="text-gray text-sm text-center">haben Sie schon ein kudenkanto ? <a href="{{route('customer.login_form')}}">Heir einloggen</a></p>--}}
                @else
                    <div class="alert alert-danger alert-dismissible fade show" >
                        <strong>Ihre Sitzung ist abgelaufen, bitte versuchen Sie erneut, sich anzumelden. <a href="{{route('customer.register_form')}}"> Klicken Sie hier, um den Vorgang erneut zu starten</a></strong>

                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>--}}
                    </div>

                @endif

            </div>
        </div>
    </div>
    {{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
    {{--<div class="col-md-8">--}}
    {{--<div class="card">--}}
    {{--<div class="card-header">{{ __('Login') }}</div>--}}

    {{--<div class="card-body">--}}
    {{--<form method="POST" action="{{ route('login') }}">--}}
    {{--@csrf--}}

    {{--<div class="form-group row">--}}
    {{--<label for="email"--}}
    {{--class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="email" type="email"--}}
    {{--class="form-control @error('email') is-invalid @enderror" name="email"--}}
    {{--value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

    {{--@error('email')--}}
    {{--<span class="invalid-feedback" role="alert">--}}
    {{--<strong>{{ $message }}</strong>--}}
    {{--</span>--}}
    {{--@enderror--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--<label for="password"--}}
    {{--class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="password" type="password"--}}
    {{--class="form-control @error('password') is-invalid @enderror" name="password"--}}
    {{--required autocomplete="current-password">--}}

    {{--@error('password')--}}
    {{--<span class="invalid-feedback" role="alert">--}}
    {{--<strong>{{ $message }}</strong>--}}
    {{--</span>--}}
    {{--@enderror--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--<div class="col-md-6 offset-md-4">--}}
    {{--<div class="form-check">--}}
    {{--<input class="form-check-input" type="checkbox" name="remember"--}}
    {{--id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

    {{--<label class="form-check-label" for="remember">--}}
    {{--{{ __('Remember Me') }}--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row mb-0">--}}
    {{--<div class="col-md-8 offset-md-4">--}}
    {{--<button type="submit" class="btn btn-primary">--}}
    {{--{{ __('Login') }}--}}
    {{--</button>--}}

    {{--@if (Route::has('password.request'))--}}
    {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
    {{--{{ __('Forgot Your Password?') }}--}}
    {{--</a>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection


