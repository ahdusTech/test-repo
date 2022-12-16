@extends('customer-portal.layout.customer')
@section('title', 'Auction')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Meine Auktionen</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-holder">
                                <ul class="menu">
                                    <li><a class="h4 {{$type == 'planned' ? 'active' : ''}}" href="{{route('customer.auction.my', 'planned')}}"> <span>Geplante</span> Auktionen ({{$planned}})</a></li>
                                    <li><a class="h4 {{$type == 'active' ? 'active' : ''}}" href="{{route('customer.auction.my', 'active')}}"><span>Aktive</span> Auktionen ({{$active}})</a></li>
                                    <li><a class="h4 {{$type == 'won' ? 'active' : ''}}" href="{{route('customer.auction.my', 'won')}}"><span>Gewonnene</span> Auktionen ({{$won}})</a></li>
                                    <li><a class="h4 {{$type == 'lost' ? 'active' : ''}}" href="{{route('customer.auction.my', 'lost')}}"><span>Verlorene</span> Auktionen ({{$lost}})</a></li>
                                </ul>
                                @if ($type == 'planned')
                                    <p class="mb-4">Hier finden Sie alle Auktionen für die Sie bei einer geplanten Auktion bereits geboten haben.</p>
                                @elseif ($type == 'active')
                                    <p class="mb-4">Hier finden Sie alle Auktionen für die Sie bei einer aktiven Auktion geboten haben.</p>
                                @elseif ($type == 'won')
                                    <p class="mb-4">Hier finden Sie alle Auktionen für die Sie geboten haben und die Auktion gewonnen haben. </p>
                                @elseif ($type == 'lost')
                                    <p class="mb-4">Hier finden Sie alle Auktionen für die Sie geboten haben und die Auktion verloren haben. </p>
                                @endif
                                <table class="table table-striped  auction-listing" style="width: 100%;">
                                    <thead>
                                    <tr class="table-active">
                                        <th width="25%" class="domain" >Domain</th>
                                        <th width="9%" class="text-right start_date">Startdatum</th>
                                        <th width="9%" class="text-right start_date">Enddatum</th>
                                        <th width="6%" class="text-right">Startpreis</th>
                                        <th width="6%" class="text-right">Schritt/Tag</th>
                                        <th width="6%" class="text-right text-dark">Aktuell</th>
                                        <th width="6%" class="text-right text-dark">Rabatt</th>
                                        <th width="12%" class="text-right text-dark">Restzeit</th>
                                        <th width="6%" class="text-right text-dark">Mein Gebot</th>
                                        <th width="6%" class="text-right">Endpreis</th>
                                        <th width="7%" class="text-center no-sort">Bieten</th>
                                    </tr>
                                    </thead>
                                    <tbody>  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('themes/data-table/css/data-table-bootstrap.css')}}">
    <style>
        .table-holder{
            padding: 0 20px;
            width: 100%;
        }
        .table-holder table{
            width: 100%;
        }
        .table-holder ul.menu{
            padding: 10px 0;
            margin: 0;
            list-style: none;
            overflow:hidden;
        }
        .table-holder ul.menu li{
            float: left;
            border-left: 1px solid #858585;
            padding: 0 10px;

        }.table-holder ul.menu li:hover a{
             text-decoration: underline;

         }
        .table-holder ul.menu li a{
            font-weight: 600;
            /*font-size: 14px;*/
            color: #858585;
        }
        .table-holder ul.menu li:first-child{
            padding: 0 10px 0 0;
            border-left: 0;
        }
        .table-holder ul.menu li a.active span{
            color: #67b100;
        }
        .table-holder ul.menu li a.active{
            color: #0b2e13;
        }
        .table-holder .table th{
            font-weight: 600;
        }
        .table-holder .table th, .table td{
            padding: 5px;
            /*font-size: 13px;*/
            font-size: 16px;
        }
        .table-holder tfoot a{
            color: #0b2e13;
            text-decoration: underline ;
        }
        .table-holder .btn-sm{
            padding: 2px 10px;
            font-size: 12px;
        }
        .table-holder .table th{
            border-bottom: 2px solid #a9a9a9;
            border-right: 2px solid #a9a9a9;
        }
        .table-holder .table td{
            border-right: 2px solid #a9a9a9;
        }
        .table-holder .table td:last-child{
            border-right: 0;
        }
        .table-holder .table th:last-child{
            border-right: 0;
        }
        a.domain:hover{
            text-decoration: underline;
        }


        .auction-bid-table {
            width: 100%;
            height: 150px;
            overflow: hidden;
            overflow-y: scroll;
            max-height: 150px;

        }
        .auction-bid-table table {
            height: 120px;
            max-height: 120px;
        }
        .auction-bid-table table tr{
            padding-top:5px;
            padding-bottom:5px;
            cursor: pointer;
        }
        .auction-bid-table table tr.selected{
            background: #0c84ff;
            color: white;
        }
        .auction-bid-table table tr.disabled{
            color: gray;
            cursor: not-allowed;
        }
        .auction-bid-table table td{
            border: none;
        }
        .auction-bid-table table td.bidder{
            color: black;
            font-weight: bold;
        }
    </style>

@endsection
@section('scripts')
    <script src="{{url('themes/data-table/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/data-table-localte.js')}}"></script>
    <script src="{{url('themes/data-table/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/adomino-common.js')}}"></script>
    <script src="{{asset('js/modules/auctions.js')}}"></script>
    <script>
        var table;
        var pageLength = 10;

        $(document).ready(function (){
            table = $('.auction-listing').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                /*destroy: true,*/
                paging: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                },
                oLanguage: getDataTableLanguage(),
                ajax: {
                    url: '{{ route('customer.auction.my',$type) }}',
                },
                columns: [
                    {data: 'domain', name: 'domain'  },
                    {data: 'start_date', name: 'start_date', class: 'text-right', },
                    {data: 'end_date', name: 'end_date', class: 'text-right'},
                    {data: 'start_price', name: 'start_price', class: 'text-right'},
                    {data: 'average_per_day', name: 'average_per_day', class: 'text-right'},
                    {data: 'actual', name: 'actual', class: 'text-right  text-success' ,"type": 'numeric'},
                    {data: 'discount', name: 'discount', class: 'text-right text-success' ,"type": 'numeric'},
                    {data: 'remaining_time', name: 'remaining_time', class: 'text-right text-danger' },
                    {data: 'bid_price', name: 'bid_price', class: 'text-right' },
                    {data: 'end_price', name: 'end_price', class: 'text-right', "type": "numeric" },
                    {data: 'offer', name: 'offer', class: 'text-center ',orderable: false, searchable: false, },
                ],
                columnDefs: [{
                    orderable: true,
                    targets: 0,
                }],
                "dom": '<"top"<"actions action-btns"B><"action-filters">><"clear">rt<"bottom"<"actions">i{{$type == 'finished' ? '': 'p' }}>',
                "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, 'All']],

                @if ($type == 'planned')
                order: [[1, 'asc'],[2, 'asc'],[0, 'asc']],
                @elseif ($type == 'active')
                order: [[3, 'asc']],
                @elseif ($type == 'won')
                order: [[2, 'desc']],
                @elseif ($type == 'lost')
                order: [[2, 'desc']],
                @endif

                bInfo: true,
                "pageLength": pageLength,
                buttons: [ ],
                drawCallback: function (data, callback, settings, json) {
                    var recordsTotal = data.json.recordsTotal;
                    console.log(recordsTotal);
                    if (recordsTotal > pageLength){
                        $('.dataTables_paginate').css('display', 'block');
                    }else {
                        $('.dataTables_paginate').css('display', 'none');
                    }


                    countdown_timer();
                    var api = this.api();
                    $('.dataTables_info').addClass('text-right').css('padding-top', 0).css('padding-bottom', '1rem').html('Preise in EUR und exkl. Ust.');
                    $('.dataTables_paginate').css('float', 'right');
                },

            });

            table.columns().iterator('column', function (ctx, idx) {
                if (!$(table.column(idx).header()).hasClass('no-sort')) {
                    if ($(table.column(idx).header())[0].innerHTML.indexOf('sort-icon') === -1) {
                        $(table.column(idx).header()).append('<span class="sort-icon"/>');
                    }
                }
            });




        });

    </script>
@endsection
{{--@section('modal')
    @include('customer-portal.layout.modals.customer-auction')
    @include('layouts.modal-layout');
@endsection--}}
