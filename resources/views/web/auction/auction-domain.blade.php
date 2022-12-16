@extends('layouts.base')
@section('content')
    <div class="content-wrapper  mt-5">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                        <div class="biding-text-blog">
                            <h3>{{__('auctions.domain_auction_heading')}}</h3>
                            <h2 class="text-warning">{{$auction->domain}}</h2>
                            <h3>{!!__('auctions.domain_auction_sub_heading')!!}</h3>
                            <p>
                                {!! __('auctions.domain_auction_description') !!}
                                <i class="fas fa-info-circle text-success"></i>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                        <div class="biding-blog">
                            <!-- Row 1 -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_start_price')}}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h3>{{number_format($auction->start_price, 0, ',', '.')}} €</h3>
                                </div>
                                <div class="col-md-4"> </div>
                            </div>
                            <!-- Row 2 -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_start_date_time')}}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h3>{{\Carbon\Carbon::parse($auction->start_date)->format('d.m.Y H:i')}} MEZ</h3>
                                </div>
                                <div class="col-md-4"> </div>
                            </div>
                            <!-- Row 3 -->
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>{{__('auctions.domain_auction_actual_price')}}</strong>
                                </div>
                                <div class="col-md-4 text-right">
                                    <strong>
                                        @if (is_numeric($auction->actual_price()))
                                            {{number_format($auction->actual_price(), 0, ',', '.')}} €
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </div>
                                <div class="col-md-4">
                                    @if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )
                                        <button type="button" class="btn btn-success">{{__('auctions.domain_auction_button_text')}}</button>


                                    @endif

                                </div>
                            </div>
                            <!-- Row 4 -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <strong>{{__('auctions.domain_auction_actual_discount')}}</strong>
                                </div>
                                <div class="col-md-4 text-right">
                                    @if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )
                                        <strong>{{number_format($auction->discount(), 0, ',', '.')}}%</strong>
                                    @else
                                        <strong>-</strong>
                                    @endif

                                </div>
                            </div>
                            <!-- Row 5 -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_latest_price')}}</h3>
                                </div>
                                <div class="col-md-4  text-right">
                                    <h3>
                                        @if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )
                                            @if (is_numeric($auction->latest_price()))
                                                {{number_format($auction->latest_price(), 0, ',', '.')}}  €
                                            @else
                                                -
                                            @endif
                                        @else
                                            <strong>-</strong>
                                        @endif

                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    @if (!\Carbon\Carbon::parse($auction->end_date)->subDay(1)->isPast() and \Carbon\Carbon::parse($auction->start_date)->isPast() )
                                        <span class="text-danger text-bold">in <span class="data-countdown one_day" data-seconds="{{$remaining_seconds}}" data-countdown="{{$next_date}}"></span></span>
                                    @endif

                                </div>
                            </div>
                            <!-- Row 6 -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_latest_discount')}}</h3>
                                </div>
                                <div class="col-md-4  text-right">
                                    <h3>{{number_format($auction->latest_discount(), 0, ',', '.')}} %</h3>
                                </div>
                                <div class="col-md-4"> </div>
                            </div>
                            <!-- Row 7 -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_end_price')}}</h3>
                                </div>
                                <div class="col-md-4  text-right">
                                    <h3>{{number_format($auction->end_price, 0, ',', '.')}} €</h3>
                                </div>
                                <div class="col-md-4"> </div>
                            </div>
                            <!-- Row 8 -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <h3>{{__('auctions.domain_auction_end_date_time')}}</h3>
                                </div>
                                <div class="col-md-4  text-right">
                                    <h3>{{\Carbon\Carbon::parse($auction->end_date)->format('d.m.Y H:i')}} MEZ</h3>
                                </div>
                                <div class="col-md-4"> </div>
                            </div>
                            <!-- Row 9 -->
                            <div class="row">
                                <div class="col-md-8 text-right">
                                    <p>{{__('auctions.exclusive_vat')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
@section('styles')
    <style>
    .biding-text-blog h3{
        font-size: 26px;
        margin-bottom: 20px;
        color: #6c757d;
    }
    .biding-text-blog h2{
        font-size: 40px;
        margin-bottom: 20px;
        color: #67b100;
        font-weight: bold;
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
        font-size: 16px;
        margin-bottom: 5px;
        color: #6c757d;
    }
    .biding-blog strong{
        color: #67b100;
        font-size: 20px;
        margin-bottom: 10px;
    }
    </style>

@endsection
@push('scripts')
    <script src="{{asset('js/adomino-common.js')}}"></script>
    <script>
        $(document).ready(function (){
            countdown_timer()
        });
    </script>
@endpush
