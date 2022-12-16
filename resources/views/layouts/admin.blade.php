<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>NZ.Photos New Zealand Stockphotos</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{url('themes/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('themes/data-table/css/data-table-bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('themes/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('themes/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('themes/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('themes/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{url('css/adomino-theme.min.css')}}">
    <link rel="stylesheet" href="{{url('css/adomino.css')}}">
    <script src="{{url('themes/jquery/jquery.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- <script>
        window.addEventListener('beforeunload', function (e) {
            $('.data_table_yajra_manual').hide();
            $('#statisticLoader').show();
            $('#domainLoader').show();
        });
        var clock_url =  '{{route('clock', 'admin')}}';
        var refresh = 1000;
        /*calculate_time()*/

        @php
            $date = new DateTime();
            $timeZone = $date->getTimezone();
            $zone = $timeZone->getName();
        @endphp


    </script> --}}

    @yield('css')
</head>
{{-- <body class="hold-transition sidebar-mini" onload=display_time()> --}}
    <body class="hold-transition sidebar-mini">
<div class="wrapper">
    {{--style="width: 100%"--}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            {{--<li class="nav-item">--}}
            {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ route('logout') }}"--}}
            {{--onclick="event.preventDefault();--}}
            {{--document.getElementById('logout-form').submit();" role="button">--}}
            {{--<i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Abmelden--}}
            {{--</a>--}}
            {{--</li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ Auth::guard('web')->user()->name }} &nbsp;<i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="nav-link" href="{{ route('2fa-settings') }}">
                        <i class="fas fa-fingerprint"></i>&nbsp;&nbsp;2FA-Einstellungen
                    </a>
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" role="button">
                        <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Abmelden
                    </a>
                </div>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{route('dashboard')}}" class="brand-link">
            {{--<span class="brand-text h3"><b>Adomino.</b>net</span>--}}
            <img src="{{url('img/white_logo.png')}}" style="width: 60%; margin-left: 45px; margin-right: 15px;"/>
        </a>
        <div class="brand-link" id="clock" style="text-align: center;font-size: 12px;padding: 7px">
            {{date('Y-m-d')}}&nbsp;&nbsp;&nbsp;{{date('H:i')}}
        </div>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    {{--  <li class="nav-item @if($sidebar == 'Logos' or $sidebar == 'email_templates') menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-archway"></i>
                            <p>
                                Dynamische Inhalte
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.email_templates')}}" class="nav-link @if($sidebar == 'email_templates') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>E-Mail Templates</p>
                                </a>
                            </li>
                            <!--li class="nav-item">
                                <a href="{{route('logo')}}" class="nav-link @if($sidebar == 'Logos') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>Kundenlogos</p>
                                </a>
                            </li-->
                        </ul>
                    </li>  --}}
                     <li class="nav-item">
                        <a href="{{route('admin.customers')}}" class="nav-link {{ Route::is('admin.customers') ? 'active' : '' }} ">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Kunden
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.photos') }}" class="nav-link {{ Route::is('admin.photos') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Fotoverwaltung
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::is('admin.categories') || Route::is('admin.subcategories')  ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-archway"></i>
                               <span style="font-size: 15px">
                                Dynamische Inhalte
                                </span>
                                <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                             <li class="nav-item">
                                <a href="{{ route('admin.categories') }}" class="nav-link {{ Route::is('admin.categories') ? 'active bg-secondary' : '' }} ">
                                    <i class="nav-icon fas"></i>
                                    <p>Kategorien</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.subcategories') }}" class="nav-link {{ Route::is('admin.subcategories') ? 'active bg-secondary' : '' }} ">
                                    <i class="nav-icon fas"></i>
                                    <p>Unterkategorien</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ Route::is('admin.home') ? 'menu-open' : '' }} ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Einstellungen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                             <li class="nav-item">
                                <a href="{{route('admin.home')}}" class="nav-link {{ Route::is('admin.home') ? 'active' : '' }} ">
                                    <i class="nav-icon fas"></i>
                                    <p>Benutzer</p>
                                </a>
                            </li>
                            {{--<li class="nav-item">
                                <a href="{{route('admin.customers')}}" class="nav-link @if($sidebar == 'Kunde') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>{{__('admin-customers.title')}}</p>
                                </a>
                            </li>
                            {{--  <li class="nav-item">
                                <a href="{{route('customer.profile')}}" class="nav-link @if(Route::currentRouteName() == 'customer.profile') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>{{__('customers-sidebar.profile')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('customer.2fa-settings')}}" class="nav-link @if(Route::currentRouteName() == 'customer.2fa-settings') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>{{__('customers-sidebar.security')}}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('customer.delete')}}"  class="nav-link  @if(Route::currentRouteName() == 'customer.delete') active @endif">
                                    <i class="nav-icon fas"></i>
                                    <p>{{__('customers-sidebar.delete_account')}} </p>
                                </a>  --}}
                            {{--  </li>  --}}

                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>
    @yield('content')
</div>
<div id="adominoModalContent"> </div>
<script src="{{url('themes/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('themes/data-table/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('js/data-table-localte.js')}}"></script>
<script src="{{url('themes/data-table/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('themes/select2/js/select2.full.min.js')}}"></script>
<script src="{{url('themes/moment/moment.min.js')}}"></script>
<script src="{{url('js/moment-timezone.min.js')}}"></script>
<script src="{{url('themes/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('themes/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{url('themes/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{url('js/adomino-theme.min.js')}}"></script>
<script src="{{asset('js/adomino-common.js')}}"></script>
<script src="{{asset('js/adomino.js')}}"></script>
@yield('scripts')
@yield('modals')
</body>
</html>
