<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{url('themes/fontawesome-free/css/all.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/adomino-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adomino.css')}}">
    <script>
        cookie_settings_heading = '{{__('messages.cookie_settings')}}';
    </script>
    <style>
        body{
            overflow-x: hidden;
        }
        /*.form-container {
            height: 80vh;
            position: relative;
        }
        .form-container .align-veriticle-center{
            position: absolute;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }*/



    </style>
</head>
<body class="@yield('bodyClass') bg-light">

<nav class="px-5 py-3 navbar flex-column flex-sm-row justify-content-center justify-content-sm-between">

    <a href="{{config('app.url')}}" class="text-decoration-none">
        <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="{{config('app.name')}} Logo" width="200"/>
        <div class="text-dark site-slogan">{{__('messages.site_slogan')}}</div>
    </a>
    @if (Route::currentRouteName() !== 'landingpage.send')
        <div class="dropdown mt-2 mt-sm-0">
            <a href="#">
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

<div class="row justify-content-center  form-container">
    <div class="align-veriticle-center py-5">
        @yield('content')
    </div>
</div>

{{--<footer class="footer px-5 text-white">
    <div class="col-md">
        {!! __('messages.copyright') !!}{{\Illuminate\Support\Carbon::now()->format('Y')}} {!! __('messages.copyright_reserved') !!}
    </div>
    <div class="col-auto">
        <a class="text-light" href="#cookieSettings">{{__('messages.cookie_settings')}}</a>
        <a class="ml-2 text-light" href="{{route('static.dataprivacy')}}">{{__('messages.data_privacy')}}</a>
        <a class="ml-2 text-light" href="{{route('static.imagelicences')}}">{{__('messages.image_licences')}}</a>
        <a class="ml-2 text-light" href="{{route('static.imprint')}}">{{__('messages.imprint')}}</a>
    </div>
</footer>--}}
<footer class="footer px-5 text-white">
    <div class="col-md">
        {!! __('messages.copyright') !!}{{\Illuminate\Support\Carbon::now()->format('Y')}} {!! __('messages.copyright_reserved') !!}
    </div>
    <div class="col-auto">
        <a class="text-light" href="#cookieSettings">{{__('messages.cookie_settings')}}</a>
        <a class="ml-2 text-light" href="{{route('static.dataprivacy')}}">{{__('messages.data_privacy')}}</a>
        <a class="ml-2 text-light" href="{{route('static.imagelicences')}}">{{__('messages.image_licences')}}</a>
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
                password.addClass('is-invalid');
                password.parent('div').next('.custom_validation').remove();
                password.parent('div').after('<small class="text-danger custom_validation error">{{__("auth.password_client_warning_message")}}</small>');


            } else {
                password.addClass('is-valid');
                password.parent('div').next('.custom_validation').remove();
                /*password.parent('div').after('<small class="text-success custom_validation error">{{__("auth.password_client_success_message")}}</small>');*/
            }

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
                /* password_confirmation.parent('div').after('<small class="text-success custom_validation error">{{__("auth.password_confirmation_client_success_message")}}</small>');*/


            } else {
                password_confirmation.addClass('is-invalid');
                password_confirmation.parent('div').next('.custom_validation').remove();
                password_confirmation.parent('div').after('<small class="text-danger custom_validation error">{{__("auth.password_confirmation_client_warning_message")}}</small>');

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
                    thisS.parent('div').after('<small class="text-danger custom_validation error">' + thisS.attr('data-message') + '</small>');
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
                    thisI.parent('div').after('<small class="text-danger custom_validation error">' + thisI.attr('data-message') + '</small>');
                }

            })
            if (error) {
                e.preventDefault()
            } else {
                thisForm.submit();
            }
        })

        $(document).on('submit', '.customer_reg_form', function (e) {
            /* e.preventDefault()*/
            var thisForm = $(this);
            console.log('form submit');
            var error = 0;
            thisForm.find('select').each(function () {
                var thisS = $(this);
                thisS.removeClass('is-invalid');
                thisS.removeClass('is-valid');
                if (!thisS.find(':selected').val()) {
                    error++;
                    thisS.addClass('is-invalid');
                    thisS.next('.custom_validation').remove();
                    thisS.after('<small class="text-danger custom_validation error">' + thisS.attr('data-message') + '</small>');
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
                    thisI.after('<small class="text-danger custom_validation error">' + thisI.attr('data-message') + '</small>');
                }

            })
            if (error) {
                e.preventDefault()
            } else {
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
