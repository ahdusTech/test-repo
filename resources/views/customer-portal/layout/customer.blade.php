<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/') }}">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Stocfoto Kundenbereich</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
        @include('customer-portal.layout.partials.styles')
        @yield('styles')
        {{--  @php
            $date = new DateTime();
            $timeZone = $date->getTimezone();
            $zone = $timeZone->getName();

            $user = \Illuminate\Support\Facades\Auth::guard(\App\Models\Customer\Customer::$guardType)->user();
            {{--  $user_id = $user->id;  --}}
            $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

            $planned = \App\Models\Customer\CustomerAuction::whereHas('auction',function($q) use ($now) {
                                                $q->where('start_date', '>', $now)
                                                    ->where('sold_at', null);
                                            })
                                            ->where(['status' => \App\Models\Customer\CustomerAuction::$bided, 'customer_id' => $user_id])
                                            ->get()->count();
            $active = \App\Models\Customer\CustomerAuction::whereHas('auction',function($q) use ($now) {
                $q->where('start_date', '<', $now)->where('sold_at', null)
                    ->where('end_date', '>', $now);
            })
                ->where(['status' => \App\Models\Customer\CustomerAuction::$bided, 'customer_id' => $user_id])
                ->get()->count();
        @endphp  --}}
        {{--  <script>
            var timezone =  '{{$zone}}';
            var clock_url =  '{{route('clock','customer')}}';
            var url = '{{url('/')}}';
            var user_id= '{{\Illuminate\Support\Facades\Auth::guard(\App\Models\Customer\Customer::$guardType)->id()}}';
            var customer_login = '{{route('customer.login_form')}}';
            var refresh = 500;
            console.log('timezone test => ', timezone)
            window.addEventListener('beforeunload', function (e) {
                $('.data_table_yajra_manual').hide();
                $('#statisticLoader').show();
                $('#domainLoader').show();
            });





        </script>  --}}
    </head>
    <body class="hold-transition sidebar-mini" onload="display_time()">
        <div class="wrapper">
            @include('customer-portal.layout.partials.nav')
            @include('customer-portal.layout.partials.sidebar')
            @yield('content')
        </div>

        <div id="adominoModalContent"> </div>


        @include('customer-portal.layout.partials.scripts')
        @include('customer-portal.layout.modals.bid-auction')
        @include('layouts.modal-layout');

        @yield('modal')
        @yield('scripts')
    </body>
</html>
