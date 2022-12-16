@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert" style="margin-bottom: 25px;">
                        {{ session('status') }}.
                    </div>
                @endif<!--
                <p class="login-box-msg">Anmeldung</p> -->
                <p class="login-box-msg" style="font-size: 1rem !important;margin-top: -10px;">Wenn Sie Ihr Passwort vergessen haben, können Sie es hier zurückrücksetzen.</p>
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input autofocus class="form-control @error('email') is-invalid @enderror"
                               placeholder="E-Mail"
                               name="email"
                               value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback error" role="alert">
{{--                            <!-- <strong>{{ $message }}</strong> -->--}}
                            <strong>Geben Sie Ihre E-Mail-Adresse ein.</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit"
                                    class="btn btn-primary btn-block">{{ __('Passwort Link senden') }}</button>
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
