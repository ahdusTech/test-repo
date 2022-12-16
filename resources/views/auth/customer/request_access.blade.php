<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{url('themes/fontawesome-free/css/all.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{asset('css/adomino-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adomino.css')}}">--}}
    <script>
        cookie_settings_heading = '{{__('messages.cookie_settings')}}';
    </script>
    <style>
        body{
            overflow-x: hidden;
            padding-bottom: 0px !important;
            margin: 0;
            font-family: "Work Sans", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #fafafa;
        }
        .form-container{
            top: 50%;
            position: absolute;
            transform: translateY(-50%);
        }

        .login-box , .register-box{
            width: 360px
        }


        @media (max-width: 576px) {
            .login-box, .register-box {
                margin-top: .5rem;
                width: 100%
            }
        }

        .login-box .card, .register-box .card {
            margin-bottom: 0
        }

        .login-card-body, .register-card-body {
            background-color: #fff;
            border-top: 0;
            color: #666;
            padding: 20px
        }

        .login-card-body .input-group .form-control, .register-card-body .input-group .form-control {
            border-right: 0
        }

        .login-card-body .input-group .form-control:focus, .register-card-body .input-group .form-control:focus {
            box-shadow: none
        }

        .login-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text, .login-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text, .register-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text, .register-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text {
            border-color: #80bdff
        }

        .login-card-body .input-group .form-control.is-valid:focus, .register-card-body .input-group .form-control.is-valid:focus {
            box-shadow: none
        }

        .login-card-body .input-group .form-control.is-valid ~ .input-group-append .input-group-text, .login-card-body .input-group .form-control.is-valid ~ .input-group-prepend .input-group-text, .register-card-body .input-group .form-control.is-valid ~ .input-group-append .input-group-text, .register-card-body .input-group .form-control.is-valid ~ .input-group-prepend .input-group-text {
            border-color: #67b100
        }

        .login-card-body .input-group .form-control.is-invalid:focus, .register-card-body .input-group .form-control.is-invalid:focus {
            box-shadow: none
        }

        .login-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text, .register-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text {
            border-color: #dc3545
        }

        .login-card-body .input-group .input-group-text, .register-card-body .input-group .input-group-text {
            background-color: transparent;
            border-bottom-right-radius: .25rem;
            border-left: 0;
            border-top-right-radius: .25rem;
            color: #777;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        .login-box-msg, .register-box-msg {
            margin: 0;
            padding: 0 20px 20px;
            text-align: center
        }

        .social-auth-links {
            margin: 10px 0
        }

        .dark-mode .login-card-body, .dark-mode .register-card-body {
            background-color: #343a40;
            border-color: #6c757d;
            color: #fff
        }

        .dark-mode .login-logo a, .dark-mode .register-logo a {
            color: #fff
        }
        .login-box-msg {
            font-size: 20px !important;
        }

        .input-group:not(.has-validation) > .custom-file:not(:last-child) .custom-file-label::after, .input-group:not(.has-validation) > .custom-select:not(:last-child), .input-group:not(.has-validation) > .form-control:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group > .input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group > .input-group-prepend:not(:first-child) > .input-group-text {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .input-group > .custom-file, .input-group > .custom-select, .input-group > .form-control, .input-group > .form-control-plaintext {
            position: relative;
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
            margin-bottom: 0;
        }
        .input-group-append {
            margin-left: -1px;
        }
        .input-group-append, .input-group-prepend {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }

        .input-group-text {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            padding: .375rem .75rem;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
        }

        .login-box  a:hover, .register-box   a:hover {
            color: #0056b3;
            text-decoration: none;
        }
        .login-box a, .register-box  a {
            color: #428bca !important;
            text-decoration: none !important;
            background-color: transparent !important;
        }
        input[type=checkbox], input[type=radio] {
            box-sizing: border-box;
            padding: 0;
        }
        button, input {
            overflow: visible;
        }
        button, input, optgroup, select, textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        .input-group {
            position: relative;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-align-items: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }
        .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show > .btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #428bca;
            border-color: #005cbf;
        }
        .btn:not(:disabled):not(.disabled).active, .btn:not(:disabled):not(.disabled):active {
            box-shadow: none;
        }
        .btn:not(:disabled):not(.disabled) {
            cursor: pointer;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #3071a9;
            border-color: #428bca;
        }
        .login-box .btn:hover {
            color: #ffffff;
            text-decoration: none;
        }
        [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
            cursor: pointer;
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        .btn-primary {
            color: #fff;
            background-color: #428bca;
            border-color: #428bca;
            box-shadow: none;
        }
        .login-box .btn{
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            color: white;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        [type=button], [type=reset], [type=submit], button {
            -webkit-appearance: button;
        }
        button, select {
            text-transform: none;
        }
        button, input {
            overflow: visible;
        }
        button, input, optgroup, select, textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
        button {
            border-radius: 0;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
        }

        .text-gray {
            color: #6c757d !important;
        }
        .text-sm {
            font-size: .78rem !important;
        }
        .text-center {
            text-align: center !important;
        }
        .text-bold, .text-bold.table td, .text-bold.table th {
            font-weight: 700;
        }


    </style>
    @yield('styles')
</head>
<body class="@yield('bodyClass')  bg-light">


<div class="row justify-content-center container-fluid form-container">
    <div class="align-veriticle-center my-auto">
        <div class="login-box">
            <div class="card   card-primary">

                <div class="card-body">
                    <form method="POST" action="{{ route('access_grant') }}">
                        @csrf
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

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Bestätige</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@include('common.cookie')
@stack('scripts')

</body>
</html>
