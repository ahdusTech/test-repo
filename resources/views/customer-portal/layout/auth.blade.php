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

<nav class="px-5  navbar flex-column flex-sm-row justify-content-center justify-content-sm-between">

    <a href="{{config('app.url')}}" class="text-decoration-none">
        <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="{{config('app.name')}} Logo" width="200"/>
        <div class="text-dark site-slogan">{{__('messages.site_slogan')}}</div>
    </a>
    @if (Route::currentRouteName() !== 'landingpage.send')
        <div class="dropdown mt-2 mt-sm-0">
            <a href="{{route('auction_process')}}">
                <button class="btn" type="button" id="login">
                    <strong>Auktionsablauf </strong>
                </button>
            </a>
            @if(auth()->guard('customer')->check())
                <button class="btn dropdown-toggle" type="button" id="language" data-toggle="dropdown"
                        aria-expanded="false">
                    <strong>{{auth()->guard('customer')->user()->full_name()}}</strong>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">
                    <a href="{{ route('customer.dashboard') }}">
                        <button class="btn " type="button" id="user" role="button">
                            <i class=" fas fa-tachometer-alt"></i> Kundenbereich
                        </button>
                    </a>
                    </br>
                    <a href="{{ route('customer.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <button class="btn " type="button" id="user" role="button">
                            <i class="fas fa-sign-out-alt"></i> {{__('auth.logout')}}
                        </button>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        <button class="btn" type="button" id="register">
                            <strong>{{__('auth.register')}}</strong>
                        </button>
                    </a>
                @endif
                <a href="{{ route('customer.login_form') }}">
                    <button class="btn" type="button" id="login">
                        <strong>{{__('auth.login')}}</strong>
                    </button>
                </a>

                <button class="btn dropdown-toggle" type="button" id="language" data-toggle="dropdown"
                        aria-expanded="false">
                    <img src="/img/{{LaravelLocalization::getCurrentLocale()}}.png" alt="Flag" width="25">
                    <strong>{{__('messages.' . LaravelLocalization::getCurrentLocale())}}</strong>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">
                    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('de') }}">
                        <img src="/img/de.png" alt="Flag" width="20">
                        {{__('messages.de')}}
                    </a>
                    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                        <img src="/img/en.png" alt="Flag" width="20">
                        {{__('messages.en')}}
                    </a>
                </div>
            @endif

        </div>
    @endif
</nav>
<div class="subheader" style="{{Route::currentRouteName() != 'landingpage.domain' ? 'border-bottom:none;':''}}">
    @if (Route::currentRouteName() == 'landingpage.domain')
        @foreach ($logos as $logo)
            @if ($logo->active)
                <div class="text-center" data-toggle="tooltip" data-sort="{{$logo->sort}}" data-placement="top"
                     title="{{$logo->purchased_domain}}">
                    <img src="{{Storage::disk('public')->url($logo->logo)}}" class="img-fluid d-inline-block"
                         alt="{{$logo->purchased_domain}}" width="80" height="40"/>
                </div>
            @endif
        @endforeach
    @endif
</div>

<div class="row justify-content-center container-fluid form-container">
    <div class="align-veriticle-center my-auto">
        @yield('content')
    </div>
</div>
<footer class="footer px-5 text-white">
    <div class="col-md">
        {!! __('messages.copyright') !!}{{\Illuminate\Support\Carbon::now()->format('Y')}} {!! __('messages.copyright_reserved') !!}
    </div>
    <div class="col-auto">
        <a class="text-light" href="#cookieSettings">{{__('messages.cookie_settings')}}</a>
        <a class="ml-2 text-light" href="{{route('static.dataprivacy')}}">{{__('messages.data_privacy')}}</a>
        <a class="ml-2 text-light" href="{{route('static.imagelicences')}}">{{__('messages.image_licences')}}</a>
        <a class="ml-2 text-light" href="{{route('static.agb')}}">{{__('messages.agb')}}</a>
        <a class="ml-2 text-light" href="{{route('static.imprint')}}">{{__('messages.imprint')}}</a>
    </div>
</footer>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@include('common.cookie')
@stack('scripts')
<script>
    $(document).ready(function () {
        $(document).on('keyup', '#verify_code input[name="password"]', function () {
            console.log('enter password');
            var password = $('#verify_code input[name="password"]');
            password.removeClass('is-invalid');
            password.removeClass('is-valid');
            if (password.val().length < 8) {
                if (password.val() == 0){
                    password.addClass('is-invalid');
                    password.parent('div').next('.custom_validation').remove();
                    /*password.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">Das Passwort darf nicht leer sein!</small>');*/
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>Das Passwort darf nicht leer sein!</strong> </span>';
                    password.parent('div').after(html);
                }else {
                    password.addClass('is-invalid');
                    password.parent('div').next('.custom_validation').remove();
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>{{__("auth.password_client_warning_message")}}</strong> </span>';
                    password.parent('div').after(html);
                    /*password.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">{{__("auth.password_client_warning_message")}}</small>');*/
                }


            } else {
                password.addClass('is-valid');
                password.parent('div').next('.custom_validation').remove();
                /*password.parent('div').after('<small class="text-success custom_validation invalid-feedback error">{{__("auth.password_client_success_message")}}</small>');*/
            }
            $('.invalid-feedback').show();
        });
        $(document).on('keyup', '#verify_code input[name="password_confirmation"]', function () {
            console.log('enter password');
            var password = $('#verify_code input[name="password"]');
            var password_confirmation = $('#verify_code input[name="password_confirmation"]');

            password_confirmation.removeClass('is-invalid');
            password_confirmation.removeClass('is-valid');
            if (password.val().length === password_confirmation.val().length && password.val() === password_confirmation.val()) {

                password_confirmation.addClass('is-valid');
                password_confirmation.parent('div').next('.custom_validation').remove();
                /* password_confirmation.parent('div').after('<small class="text-success custom_validation invalid-feedback error">{{__("auth.password_confirmation_client_success_message")}}</small>');*/


            } else {
                password_confirmation.addClass('is-invalid');
                password_confirmation.parent('div').next('.custom_validation').remove();
                var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>{{__("auth.password_confirmation_client_warning_message")}}</strong> </span>';
                password_confirmation.parent('div').after(html);
                /*password_confirmation.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">{{__("auth.password_confirmation_client_warning_message")}}</small>');*/

            }

        });

        $(document).on('submit', '#verify_code', function (e) {
            /* e.preventDefault()*/
            var thisForm = $(this);
            console.log('verify code');
            var error = 0;
            thisForm.find('select').each(function () {
                var thisS = $(this);
                thisS.removeClass('is-invalid');
                thisS.removeClass('is-valid');
                if (!thisS.find(':selected').val()) {
                    error++;
                    thisS.addClass('is-invalid');
                    thisS.parent('div').next('.custom_validation').remove();
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>' + thisS.attr('data-message') + '</strong> </span>';
                    thisS.parent('div').after(html);
                    /*thisS.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">' + thisS.attr('data-message') + '</small>');*/
                }

            })
            thisForm.find('input').each(function () {
                var thisI = $(this);
                thisI.removeClass('is-invalid');
                thisI.removeClass('is-valid');
                if (!thisI.val()) {
                    error++;
                    thisI.addClass('is-invalid');
                    thisI.parent('div').next('.custom_validation').remove();
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>' + thisI.attr('data-message') + '</strong> </span>';
                    thisI.parent('div').after(html);
                    /*thisI.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">' + thisI.attr('data-message') + '</small>');*/
                }
                if (thisI.attr('type') == 'password'){
                    if (thisI.val().length < 8){
                        error++;
                        thisI.addClass('is-invalid');
                        thisI.parent('div').next('.custom_validation').remove();
                        var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>Das Passwort muss mindestens 8 Zeichen lang sein</strong> </span>';
                        thisI.parent('div').after(html);
                        /*thisI.parent('div').after('<small class="text-danger custom_validation invalid-feedback error">Das Passwort muss mindestens 8 Zeichen lang sein</small>');*/
                    }


                }


            })
            $('.invalid-feedback').show()
            if (error) {
                e.preventDefault()
                return false;
            } else {
                thisForm.submit();
            }
        })

        $(document).on('submit', '.customer_reg_form', function (e) {
            /* e.preventDefault()*/
            var thisForm = $(this);
            /*console.log('form submit');*/
            var error = 0;
            thisForm.find('select').each(function () {
                var thisS = $(this);
                thisS.removeClass('is-invalid');
                thisS.removeClass('is-valid');
                if (!thisS.find(':selected').val()) {
                    error++;
                    thisS.addClass('is-invalid');
                    thisS.next('.custom_validation').remove();
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>' + thisS.attr('data-message') + '</strong> </span>';
                    thisS.after(html);
                    /*thisS.after('<small class="text-danger custom_validation invalid-feedback error">' + thisS.attr('data-message') + '</small>');*/
                }

            })
            thisForm.find('input').each(function () {
                var thisI = $(this);
                thisI.removeClass('is-invalid');
                thisI.removeClass('is-valid');
                if (!thisI.val()) {
                    error++;
                    thisI.addClass('is-invalid');
                    thisI.next('.custom_validation').remove();
                    var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>' + thisI.attr('data-message') + '</strong> </span>';
                    thisI.after(html);
                    /*thisI.after('<small class="text-danger custom_validation invalid-feedback error">' + thisI.attr('data-message') + '</small>');*/
                }
                if (thisI.attr('type') == 'email'){
                    console.log('email input')
                    const regix = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    console.log('validate email -> ', regix.test(thisI.val()))
                    if (!regix.test(thisI.val())){
                        error++;
                        thisI.addClass('is-invalid');
                        thisI./*parent('div').*/next('.custom_validation').remove();
                        var html = '<span class="error invalid-feedback error custom_validation" role="alert"> <strong>E-Mail Adresse ist ungültig</strong> </span>';
                        thisI.after(html);
                        /*thisI/!*.parent('div')*!/.after('<small class="text-danger custom_validation invalid-feedback error">E-Mail Adresse ist ungültig</small>');*/
                    }


                }

            })
            if (error > 0) {
                e.preventDefault();
                return false;
            } else {
                error = 0;
                thisForm.submit();
            }

        })


        $('.subheader').slick({
            autoplay: true,
            infinite: true,
            slidesToShow: 13,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 8,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 6,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 4,
                    }
                }
            ]
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
</body>
</html>
