<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/modules/auction.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/adomino.css')}}">
        <link rel="stylesheet" href="{{url('themes/fontawesome-free/css/all.min.css')}}">
        <script>
            cookie_settings_heading = '{{__('messages.cookie_settings')}}';
            var url = '{{url('/')}}';
            var user_id= '{{\Illuminate\Support\Facades\Auth::guard(\App\Models\Customer\Customer::$guardType)->id()}}';
            var customer_login = '{{route('customer.login_form')}}';
        </script>
        @yield('styles')
    </head>
    <body class="@yield('bodyClass') {{isset($class) ? 'bg-white' :''}}">
        <nav class="px-5 navbar flex-column flex-sm-row justify-content-center justify-content-sm-between">
            {{--@if(Cookie::get('domain_hash'))
                <a href="{{route('landingpage.domain', [ 'hash' => Cookie::get('domain_hash')], false )}}" class="text-decoration-none">
            @else
                <a href="{{config('app.url')}}" class="text-decoration-none">
            @endif--}}
            <a href="{{config('app.url')}}" class="text-decoration-none">
                <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="{{config('app.name')}} Logo" width="200" />
                <div class="text-dark site-slogan">{{__('messages.site_slogan')}}</div>
            </a>

            @if (Route::currentRouteName() !== 'landingpage.send')

                <div class="dropdown mt-2 mt-sm-0">
                    @if (Route::currentRouteName() !== 'landingpage.domain')
                        @include('layouts.partials.auction-process')
                        @if(auth()->guard('customer')->check())
                            @include('layouts.partials.customer-menu')
                        @else
                            @if (Route::currentRouteName() !== 'landingpage.domain')
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <button class="btn" type="button" id="register"  >
                                            <strong>{{__('auth.register')}}</strong>
                                        </button>
                                    </a>
                                @endif
                                <a   href="{{ route('customer.login_form') }}">
                                    <button class="btn" type="button" id="login" >
                                        <strong>{{__('auth.login')}}</strong>
                                    </button>
                                </a>

                            @endif
                            {{--<button class="btn dropdown-toggle" type="button" id="language"   data-toggle="dropdown" aria-expanded="false">
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
                            </div>--}}
                            @include('layouts.partials.language')
                        @endif
                    @else

                            <div class="dropdown mt-2 mt-sm-0">
                                @if (isset($domain->landingpage_mode) && ($domain->landingpage_mode == 'auction_soon' || $domain->landingpage_mode == 'auction_active'))
                                    {{--<a href="{{route('auction_process')}}">
                                        <button class="btn" type="button" id="login">
                                            <strong>Auktionsablauf</strong>
                                        </button>
                                    </a>--}}
                                    @include('layouts.partials.auction-process')

                                    @if(auth()->guard('customer')->check())
                                        {{--<button class="btn dropdown-toggle" type="button" id="customer" data-preffered-lang="{{session('preferred_lang')}}" data-toggle="dropdown" aria-expanded="false">
                                            <strong>{{auth()->guard('customer')->user()->full_name()}}</strong>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customer">
                                            <a  href="{{ route('customer.dashboard') }}">
                                                <button class="btn " type="button" id="user"   role="button">
                                                    <i class=" fas fa-tachometer-alt"></i> Kundenbereich
                                                </button>
                                            </a>
                                            </br>
                                            <a  href="{{ route('customer.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <button class="btn " type="button" id="user"   role="button">
                                                    <i class="fas fa-sign-out-alt"></i> {{__('auth.logout')}}
                                                </button>
                                            </a>
                                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>--}}
                                        @include('layouts.partials.customer-menu')
                                    @else

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}">
                                                <button class="btn" type="button" id="register"  >
                                                    <strong>{{__('auth.register')}}</strong>
                                                </button>
                                            </a>
                                        @endif
                                        <a   href="{{ route('customer.login_form') }}">
                                            <button class="btn" type="button" id="login" >
                                                <strong>{{__('auth.login')}}</strong>
                                            </button>
                                        </a>



                                    @endif
                                @else
                                    @include('layouts.partials.language')
                                @endif



                            </div>

                    @endif


                </div>

            @endif
        </nav>
        <div class="subheader " style="{{Route::currentRouteName() != 'landingpage.domain' ? 'border-bottom:none;visibility: visible;opacity: 1;':''}}">
            @yield('logos')
        </div>
        <div class=" {{isset($class) ? $class . ' px-5 bg-white' :'container-sm py-5 '}} mt-3">
            @yield('content')
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
        {{--@include('customer-portal.layout.partials.scripts')--}}
        @stack('scripts')
        @yield('modal')
        <script src="{{asset('themes/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script>
            $(document).ready(function(){
                $(document).on('click', '#customer', function (){
                    console.log('customer clicked');
                    $(this).trigger('click')
                });
                $(document).on('click', '#language', function (){
                    console.log('customer clicked');
                    $(this).trigger('click')
                });
                @if (Route::currentRouteName() == 'landingpage.domain')
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
                @endif
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    </body>
    @include('customer-portal.layout.modals.bid-auction')
</html>
