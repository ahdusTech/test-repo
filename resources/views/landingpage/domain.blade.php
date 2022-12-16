@extends('layouts.base')

@section('content')

    <div class="row justify-content-center container-fluid form-container">
        @if ($domain->landingpage_mode && $domain->landingpage_mode == 'review')
            <h2 class="col font-weight-light text-center">
                {{ __('messages.lp_headline_top') }} {{ $domain->title ?? $domain->domain }} {{ __('messages.lp_headline_bottom_review') }}
            </h2>
        @elseif ($domain->landingpage_mode && $domain->landingpage_mode == 'sold')
            <h2 class="col font-weight-light text-center">
                {{ __('messages.lp_headline_top') }} {{ $domain->title ?? $domain->domain }} {{ __('messages.lp_headline_bottom_sold') }}
            </h2>
        @elseif ($domain->landingpage_mode && $domain->landingpage_mode == 'auction_soon')
            <div class="col-12 text-center auction_start_soon  my-auto">
                <h2 class="font-weight-light lp-first-headline">Die Auktion für den Domainnamen</h2>
                <h2 class="text-warning font-weight-bold line-break-anyware">{{$auction->domain}}</h2>
                <h2 class="font-weight-light">startet am {{\Carbon\Carbon::parse($auction->start_date)->format('d.m.Y')}}  um {{\Carbon\Carbon::parse($auction->start_date)->format('H:i')}} MEZ</h2>
                <ul class="data-countdown timer" data-seconds="{{$auction->remaining_seconds($auction->start_date)}}">
                    <li><span class="days font-weight-bold">00</span><strong>Tage</strong></li>
                    <li><span class="hours font-weight-bold">00</span><strong>Std</strong></li>
                    <li><span class="minutes font-weight-bold">00</span><strong>Min</strong></li>
                    <li><span class="seconds font-weight-bold">00</span><strong>Sek</strong></li>
                </ul>
                <p>
                    Erstellen Sie kostenlos ein <a  class="text-primary"  href="{{route('customer.register_form')}}"><u>Bieterkonto</u></a> und legen Sie mit dem Bietmanager bereits <u>vor</u> Auktionsbeginn<br> lhren Gebotspreis fest um die Auktion vor Auktionsende automatisch zu beenden.
                    <a href="{{route('auction_process')}}"><i class="fas fa-info-circle text-success"></i></a>
                </p>
            </div>

        @elseif ($domain->landingpage_mode && $domain->landingpage_mode == 'auction_ended')
            <div class="col-12 text-center auction_start_soon  my-auto">
                <h2 class="font-weight-light lp-first-headline">Die Auktion für den Domainnamen</h2>
                <h2 class="text-warning font-weight-bold line-break-anyware">{{$auction->domain}}</h2>
                <h2 class="font-weight-light">wurde beendet</h2>
            </div>
        @elseif ($domain->landingpage_mode && $domain->landingpage_mode == 'auction_active')
            <div class="row auction_active   my-auto">
                <div class="col-md-5 offset-1 px-4 pb-4 biding-text-blog ">
                    <h2 class="font-weight-light lp-first-headline text-dark">{{__('auctions.domain_auction_heading')}}</h2>
                    <h2 class="text-warning font-weight-bold line-break-anyware ">{{$domain->title ?? $auction->domain}}</h2>
                    {{--<h2 class="text-warning font-weight-bold line-break-anyware ">{{$auction->domain}}</h2>--}}
                    <h2 class="font-weight-light text-dark" >{!!__('auctions.domain_auction_sub_heading')!!}</h2>
                    <p class="text-dark lp-first-p">
                        {!! __('auctions.domain_auction_description') !!}
                        <a href="{{route('auction_process')}}">
                            <i class="fas fa-info-circle text-success"></i>
                        </a>
                    </p>
                </div>
                <div class=" col-xl-5 col-lg-5 col-md-5   offset-lg-1 offset-xl-1">
                    <div class="biding-blog">
                        <!-- Row 1 -->
                        <div class="row">
                            <div class="col-md-4">
                                <h3>{{__('auctions.domain_auction_start_date_time')}}</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <h3>{{\Carbon\Carbon::parse($auction->start_date)->format('d.m.Y H:i')}} MEZ</h3>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h3>{{__('auctions.domain_auction_start_price')}}</h3>
                            </div>
                            <div class="col-md-4 text-right">
                                <h3>{{number_format($auction->start_price, 0, ',', '.')}} €</h3>
                            </div>
                        </div>
                        <!-- Row 3 -->
                        <div class="row">
                            <div class="col-md-4">
                                <strong>{{__('auctions.domain_auction_actual_price')}}</strong>
                            </div>
                            <div class="col-md-4 text-right">
                                <strong>
                                    @if (is_numeric($auction->actual_price()))  {{number_format($auction->actual_price(), 0, ',', '.')}} € @else  - @endif
                                </strong>
                            </div>
                            <div class="col-md-4 text-left ">
                                {{--@if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )--}}
                                <button type="button" class="btn btn-success px-3 text-bold bid_manager" data-id="{{$auction->id}}">{{__('auctions.domain_auction_button_text')}}</button>
                                {{--@endif--}}

                            </div>
                        </div>
                        <!-- Row 4 -->
                        {{--<div class="row mb-4">
                            <div class="col-md-4">
                                <strong>{{__('auctions.domain_auction_actual_discount')}}</strong>
                            </div>
                            <div class="col-md-4 text-right">
                                <strong>{{$auction->discount()}}%</strong>
                            </div>
                        </div>--}}
                        <!-- Row 5 -->

                        @if ($auction->days > 1 && !\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast())
                            <div class="row">

                                    <div class="col-md-4">
                                        <h3>{{__('auctions.domain_auction_latest_price')}}</h3>
                                    </div>
                                    <div class="col-md-4  text-right">
                                        <h3>
                                            {{--@if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )
                                                @if (is_numeric($auction->latest_price()))
                                                    {{number_format($auction->latest_price(), 0, ',', '.')}}  €
                                                @else
                                                    -
                                                @endif
                                            @else
                                                <strong>-</strong>
                                            @endif--}}
                                            {{number_format($auction->latest_price(), 0, ',', '.')}}  €

                                        </h3>
                                    </div>
                                    <div class="col-md-4  ">
                                        {{-- @if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )--}}
                                        <span style="font-size: 18px" class="text-danger text-bold">in <span class="data-countdown one_day" data-seconds="{{$remaining_seconds}}" data-countdown="{{$next_date}}"></span></span>
                                        {{-- @endif--}}

                                    </div>
                            </div>
                            <!-- Row 6 -->
                            <div class="row mb-4">
                                {{--<div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_latest_discount')}}</h3>
                                </div>
                                <div class="col-md-4  text-right">
                                    <h3>{{$auction->latest_discount()}}%</h3>
                                </div>--}}

                            </div>
                        @endif
                        <!-- Row 7 -->
                        <div class="row">
                            <div class="col-md-4">
                                <h3>{{__('auctions.domain_auction_end_price')}}</h3>
                            </div>
                            <div class="col-md-4  text-right">
                                {{--<h3>{{number_format($auction->step_price(), 0, ',', '.')}} €</h3>--}}
                                <h3>{{number_format($auction->end_price, 0, ',', '.')}} €</h3>
                            </div>
                        </div>
                        <!-- Row 8 -->
                        <div class="row ">
                            <div class="col-md-4">
                                <h3>{{__('auctions.domain_auction_end_date_time')}}</h3>
                            </div>
                            <div class="col-md-4  text-right">
                                <h3>{{\Carbon\Carbon::parse($auction->end_date)->format('d.m.Y H:i')}} MEZ</h3>
                            </div>
                            <div class="col-md-4  ">
                                {{--@if($auction->days == 1 && \Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast())--}}
                                @if($auction->days == 1 || \Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast())
                                    <p style="font-size: 18px" class="text-danger text-bold">in
                                        <span class="data-countdown one_day" data-seconds="{{$remaining_seconds}}" data-countdown="{{$next_date}}"></span>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- Row 9 -->
                        <div class="row mt-4">
                            <div class="col-md-8 text-right">
                                <p>{{__('auctions.exclusive_vat')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 px-4 pb-4">
                <h2 class="font-weight-light lp-first-headline">{{ __('messages.lp_headline_top') }}</h2>
                <h2 class="text-warning font-weight-bold line-break-anyware">
                    {{--!empty($domain->title) ?? $domain->domain--}}
                    @if(isset($domain->domain))
                        @if(!empty($domain->title))
                            {{$domain->title}}
                        @elseif(!empty($domain->domain))
                            {{$domain->domain}}
                        @endif
                    @endif
                </h2>
                <h2 class="font-weight-light">{{ __('messages.lp_headline_bottom') }}</h2>

                <p class="lp-first-p">{!! __('messages.lp_instruction_1') !!}</p>
                @php($info_json=json_decode($domain->info,true))
                @if (isset($info_json[Config::get('app.locale')]))
                    <p class="lp-first-p">{{$info_json[Config::get('app.locale')]}}</p>
                @endif
                <p class="lp-first-p">{!! __('messages.lp_instruction_2') !!}</p>
            </div>
        @endif

        @if ($domain->landingpage_mode && $domain->landingpage_mode == 'request_offer')
            <div class="col-md-6 col-lg-5 offset-lg-1 col-xl-4 offset-xl-2">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => 'landingpage.send']) !!}
                        {!! Form::hidden('domain', $domain->domain) !!}

                        <div class="row">
                            <div class="form-group col-6">
                                {!! Form::select('gender', ['m' => __('messages.mr'), 'f' => __('messages.ms')], null, ['placeholder' => '-', 'class' => 'form-control w-auto' . ($errors->has('gender') ? ' is-invalid' : '')]) !!}
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::text('prename', null, ['placeholder' => __('messages.prename'), 'class' => 'form-control' . ($errors->has('prename') ? ' is-invalid' : '')]) !!}
                            @error('prename')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::text('surname', null, ['placeholder' => __('messages.surname'), 'class' => 'form-control' . ($errors->has('surname') ? ' is-invalid' : '')]) !!}
                            @error('surname')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            {!! Form::email('email', null, ['placeholder' => __('messages.email'), 'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '')]) !!}
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="g-recaptcha {{ $errors->has('g-recaptcha-response') ? 'is-invalid' : '' }}"  data-sitekey="{{config('recaptcha.api_site_key')}}"></div>
                            @error('g-recaptcha-response')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-success btn-block mt-2 font-weight-bold"
                                type="submit">{{ __('messages.request_offer_button') }}</button>

                        <div class="text-center">
                            <img src="{{asset('img/ssl-logo2.jpeg')}}" class="img-fluid mt-3 mr-5" width="100"/>
                            @if (App::isLocale('de'))
                                <img src="{{asset('img/dsgvo.jpeg')}}" class="img-fluid mt-3" height="36"/>
                            @else
                                <img src="{{asset('img/gdpr.jpeg')}}" class="img-fluid mt-3" height="36"/>
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>


                <div class="px-4 pt-3 text-center line-sm">
                    <small class="text-muted">{!! __('messages.gdpr_hint') !!}</small>
                </div>

            </div>
        @endif
    </div>

@endsection


@section('logos')
    @if ($domain->landingpage_mode && ($domain->landingpage_mode !== 'auction_active' && $domain->landingpage_mode !== 'auction_soon' && $domain->landingpage_mode !== 'auction_ended'))
        @include('layouts.logos')
    @endif

@endsection

@push('scripts')
    @include('common.recaptcha')
    <script src="{{asset('js/modules/auctions.js')}}"></script>
    @if ($domain->landingpage_mode && ($domain->landingpage_mode == 'auction_active' || $domain->landingpage_mode == 'auction_soon'))
        <script src="{{asset('js/adomino-common.js')}}"></script>
    @endif
    <script>
        $(document).ready(function (){
            @if ($domain->landingpage_mode && ($domain->landingpage_mode == 'auction_active' || $domain->landingpage_mode == 'auction_soon' || $domain->landingpage_mode == 'auction_ended'))
            countdown_timer()
            $('.subheader').css('border-bottom', 'none')
            @endif
        });
    </script>
@endpush
@section('styles')
    <style>
        .container-sm {
            min-height: 60vh;
        }
        @if ($domain->landingpage_mode &&  $domain->landingpage_mode == 'auction_soon')
            /******* Start Counter Style ***********/

        .auction_start_soon h2{
            /*font-size:25px;*/
            font-size: 1.8rem;
            color: #858585;
        }
        .auction_start_soon ul{
            list-style: none;
            margin:30px 0;
            padding: 0;
            display: inline-block;
        }
        .auction_start_soon ul li{
            float: left;
            text-align: center;
            margin-left: 15px;
            line-height: 35px;
        }
        .auction_start_soon ul li:first-child{
            margin-left: 0;
        }
        .auction_start_soon ul li span{
            color:#e3342f;;
            font-size:33px;
            display: block;
            margin-bottom: 10px;
            /*font-weight: 600;*/
        }
        .auction_start_soon ul li strong{
            font-size: 30px;
            color: #858585;
            /*font-weight: 600;*/
        }
        @elseif($domain->landingpage_mode &&  $domain->landingpage_mode == 'auction_ended')
            /******* Start Counter Style ***********/

        .auction_start_soon h2{
            /*font-size:25px;*/
            font-size: 1.8rem;
            color: #858585;
        }
        .auction_start_soon ul{
            list-style: none;
            margin:30px 0;
            padding: 0;
            display: inline-block;
        }
        .auction_start_soon ul li{
            float: left;
            text-align: center;
            margin-left: 15px;
            line-height: 35px;
        }
        .auction_start_soon ul li:first-child{
            margin-left: 0;
        }
        .auction_start_soon ul li span{
            color:#e3342f;;
            font-size:33px;
            display: block;
            margin-bottom: 10px;
            /*font-weight: 600;*/
        }
        .auction_start_soon ul li strong{
            font-size: 30px;
            color: #858585;
            /*font-weight: 600;*/
        }
        @elseif ($domain->landingpage_mode && $domain->landingpage_mode == 'auction_active'  )
            /*.container-sm {
                width: 77%;
                max-width: 80%;
            }*/
        .biding-text-blog h3{
            font-size: 1.8rem;
            /* font-size: 26px;*/
            margin-bottom: 20px;
            color: #6c757d;
            font-weight: 300 !important;
        }
        .biding-text-blog h2{
            /*font-size: 40px;*/
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #67b100;
            /*font-weight: bold;*/
        }
        .table-holder .table{
            border: 0;
        }
        .table-holder .table th, .table td{
            border-top: 0;
        }
        .table-holder .table thead th{
            border-bottom: 0;
        }
        .biding-blog h3{
            font-size: 18px;
            margin-bottom: 5px;
            color: #6c757d;
            font-weight: 400 !important;
        }
        .biding-blog strong{
            color: #67b100;
            font-size: 22px;
            margin-bottom: 10px;
        }

        @endif

    </style>

@endsection
