@extends('customer-portal.layout.auth')

@section('content')
    <div class="login-box">
        <div class="card {{--card-outline--}} card-primary">
            {{--<div class="card-header text-center">
                <img src="{{url('img/logo.png')}}" style="width: 60%; margin-left:12px;"/>
            </div>--}}
            <div class="card-body">
                @if(session('expired'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('expired')}}
                    </div>
                @else
                    <p class="login-box-msg" style="font-size: .85rem !important;">Geben Sie Ihre E-Mail-Adresse sowie Ihr neues Passwort zweimal ein.</p>
                    <form method="POST" action="{{ route('customer.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="emailHash" value="{{ $emailHash }}">
                        <div class="input-group mb-3">
                            <input autofocus class="form-control @error('email') is-invalid @enderror"
                                   placeholder="E-Mail"  readonly name="email" value="{{ $email ?? old('email') }}">
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
                @endif

            </div>
        </div>
    </div>
@endsection
