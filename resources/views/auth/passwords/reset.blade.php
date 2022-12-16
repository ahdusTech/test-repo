@extends('layouts.auth')

@section('content')
    {{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
    {{--<div class="col-md-8">--}}
    {{--<div class="card">--}}
    {{--<div class="card-header">{{ __('Reset Password') }}</div>--}}

    {{--<div class="card-body">--}}
    {{--<form method="POST" action="{{ route('password.update') }}">--}}
    {{--@csrf--}}

    {{--<input type="hidden" name="token" value="{{ $token }}">--}}

    {{--<div class="form-group row">--}}
    {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>--}}

    {{--@error('email')--}}
    {{--<span class="invalid-feedback" role="alert">--}}
    {{--<strong>{{ $message }}</strong>--}}
    {{--</span>--}}
    {{--@enderror--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
    name="password" required autocomplete="new-password">--}}

    {{--@error('password')--}}
    {{--<span class="invalid-feedback" role="alert">--}}
    {{--<strong>{{ $message }}</strong>--}}
    {{--</span>--}}
    {{--@enderror--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

    {{--<div class="col-md-6">--}}
    {{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation"
    required autocomplete="new-password">--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group row mb-0">--}}
    {{--<div class="col-md-6 offset-md-4">--}}
    {{--<button type="submit" class="btn btn-primary">--}}
    {{--{{ __('Reset Password') }}--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>
            <div class="card-body">
                <p class="login-box-msg" style="font-size: 1rem !important;">Geben Sie Ihre E-Mail-Adresse sowie Ihr neues Passwort zweimal ein.</p>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group mb-3">
                        <input autofocus class="form-control @error('email') is-invalid @enderror"
                               placeholder="E-Mail"  name="email" value="{{ $email ?? old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback error" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Passwort" autocomplete="new-password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback error" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Passwort Bestätigung"
                               name="password_confirmation">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Passwort zurücksetzen') }}</button>
                        </div>
                    </div>
                </form>

                <!-- <p class="mt-3 mb-1">
                    <a href="{{route('login')}}">Login</a>
                </p> -->
            </div>
        </div>
    </div>
@endsection
