@extends('layouts.web.app')

@section('content')
    <div class="login-box" style="width: 500px; margin: 0 auto; height: 100%">
        <div class="card {{--card-outline--}} card-primary" style="margin-top: 5%;">
            {{--<div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>--}}
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert" style="margin-bottom: 25px;">
                        {{ session('status') }}
                    </div>
                @endif<!--
                <p class="login-box-msg">Anmeldung</p> -->
                <p class="login-box-msg" style="text-align: center;font-size: 18px;">
                    Wenn Sie Ihr Passwort vergessen haben, können Sie es hier zurückrücksetzen.
                </p>
                <form action="{{ route('customer.password.reset.email') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">

                        <div style="display: flex;width: 100%;">
                            <div style="width: 10%">
                                <i class="fas fa-envelope" style="font-size: 34px;"></i>
                            </div>
                            <div style="width: 90%;">
                                <input autofocus class="form-control @error('email') is-invalid @enderror"
                                placeholder="E-Mail"
                                name="email"
                                value="{{ old('email') }}" style="font-size: 15px;margin-bottom: 2%;">
                            </div>
                        </div>

                        @error('email')
                        <span class="invalid-feedback error" role="alert">
{{--                            <!-- <strong>{{ $message }}</strong> -->--}}
                            <strong>Geben Sie Ihre E-Mail-Adresse ein.</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <div class="col-12" style="text-align: center;">
                            <button type="submit"
                                    class="btn btn-primary " style="font-size: 15px;">
                                    {{ __('Passwort Link senden') }}
                                </button>
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
