@extends('layouts.base')

@section('content')
    <div class="content-wrapper px-xl-5  px-lg-5   px-md-5  px-sm-0  px-xs-0" style="margin-top: 45px;">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 auction-overview-description{{-- my-auto--}}">
                        <div class="card border-0">
                            <div class="card-header" style="background:none;border-bottom:none;margin-top: 45px;">
                                <img class="card-img-top"  src="{{asset('img/auctions/auction-hammer-yellow.jpeg')}}"
                                     alt="Card image cap">
                            </div>

                            <div class="card-body">
                                <p class="card-text" style="margin-top: 32px;">
                                    {!! __('auctions.description') !!}
                                    <a href="{{route('auction_process')}}">
                                        <i class="fas fa-info-circle text-success"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 ">
                        <div class="row">
                            <!-- Col 1 -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="table-holder">
                                    <a href="{{route('auction.type', 'planned')}}"><h2>{!! __('auctions.planned_auctions') !!} > </h2></a>
                                    <table class="table table-striped ">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        @foreach ($planned as $item)
                                            <tr>
                                                {{--<td><a class="domain" href="{{route('landingpage.domain', encrypt($item->domain))}}">{{$item->domain}}</a></td>--}}
                                                <td><a class="domain" href="{{route('landingpage.domain',  \Illuminate\Support\Facades\Crypt::encryptString($item->domain))}}">{{$item->domain}}</a></td>
                                                <td class="text-right" ><span class="data-countdown auction-overiew-days" data-seconds="{{$item->remaining_seconds($item->start_date)}}" data-countdown="{{$item->start_date}}"></span></td>
                                            </tr>
                                        @endforeach
                                        @for($i = 1; $i <= (11 - count($planned)); $i++)
                                            <tr>
                                                <td colspan="3"></td>

                                            </tr>
                                        @endfor


                                        </tbody>
                                    </table>
                                </div>
                                <!-- Table 2 -->
                                <div class="table-holder">
                                    <a href="{{route('auction.type', 'finished')}}"><h2>{!! __('auctions.finished_auctions') !!} > </h2></a>
                                    <table class="table table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        @foreach ($closed as $item)
                                            <tr>
                                                <td><a class="domain" href="{{route('landingpage.domain',  \Illuminate\Support\Facades\Crypt::encryptString($item->domain))}}">{{$item->domain}}</a></td>
                                            </tr>
                                        @endforeach
                                        @for($i = 1; $i <= (5 - count($closed)); $i++)
                                            <tr>
                                                <td colspan="3"></td>

                                            </tr>
                                        @endfor

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Col 2 -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="table-holder">
                                    <a href="{{route('auction.type', 'active')}}"><h2>{!! __('auctions.active_auctions') !!} > </h2></a>
                                    <table class="table table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        @foreach ($active as $item)
                                            <tr>
                                                <td><a class="domain" href="{{route('landingpage.domain', \Illuminate\Support\Facades\Crypt::encryptString($item->domain))}}">{{$item->domain}}</a></td>
                                                <td class="text-right text-success">{{number_format($item->actual_price(), 0 , ',', '.')}}</td>
                                                <td class="" style="display: none;" ><span class="data-countdown auction-overiew-days" data-seconds="{{$item->remaining_seconds($item->end_date)}}" data-countdown="{{$item->end_date}}"></span></td>
                                            </tr>
                                        @endforeach
                                        @for($i = 1; $i <= (19 - count($active)); $i++)
                                            <tr>
                                                <td colspan="2"></td>

                                            </tr>
                                        @endfor
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-right">
                                                {{__('auctions.active_auction_table_footer')}}
                                            </td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/adomino-common.js')}}"></script>
    <script>
        $(document).ready(function (){
            countdown_timer()
        });
    </script>

@endpush
@section('styles')
    <style>
        .auction-overview-description a.create-account{
            color:#428bca;
            text-decoration: underline;
        }

        .table-holder {
            padding: 0 20px;
            /*margin-bottom: 70px;*/
            margin-bottom: 45px;
        }

        .table-holder .table a{
            color: #212529;
        }
        .table-holder .table a.domain:hover{
            text-decoration: underline;
            color: #212529;
        }
        .table-holder > a:hover h2 {
            text-decoration: underline;
        }
        .table-holder h2 {
            font-size: 25px;
            color: #0b2e13;
            /*margin-bottom: 20px;*/
            margin-bottom: 15px;
            font-weight: bold;
        }

        .table-holder h2 span {
            color: #67b100;
        }

        .table-holder .table th, .table td {
            padding: 0px 5px;
            font-size: 16px;
            border: 0;
            height: 30px;
        }

        .table-holder tfoot a {
            color: #0b2e13;
            text-decoration: underline;
        }
        .card-img-top{
            width: 70%;
        }
    </style>

@endsection
