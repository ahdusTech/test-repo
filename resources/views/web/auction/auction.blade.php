@extends('layouts.base')

@section('content')
    <div class="content-wrapper px-xl-5  px-lg-5   px-md-5  px-sm-0  px-xs-0">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                        <div class="row">
                            <div class="table-holder">
                                <ul class="menu">
                                    <li><a class="h4 {{$type == 'planned' ? 'active' : ''}}" href="{{route('auction.type', 'planned')}}"> <span>Geplante</span> Auktionen</a></li>
                                    <li><a class="h4 {{$type == 'active' ? 'active' : ''}}" href="{{route('auction.type', 'active')}}"><span>Aktive</span> Auktionen</a></li>
                                    <li><a class="h4 {{$type == 'finished' ? 'active' : ''}}" href="{{route('auction.type', 'finished')}}"><span>Beendete</span> Auktionen</a></li>
                                </ul>
                                <table class="table table-striped  auction-listing">
                                    <thead>
                                        <tr class="table-active">
                                            <th width="30%" class="domain" >Domain</th>
                                            <th width="9%" class="text-right start_date">Startdatum</th>
                                            <th width="9%" class="text-right start_date">Enddatum</th>
                                            <th width="6%" class="text-right">Startpreis</th>
                                            <th width="6%" class="text-right text-dark">Aktuell</th>
                                            <th width="6%" class="text-right text-dark">Rabatt</th>
                                            <th width="12%" class="text-right   text-dark">Restzeit</th>
                                            <th width="6%" class="text-right">Endpreis</th>
                                            <th width="7%" class="text-center no-sort">Bieten</th>
                                            <th width="5%" class="text-center no-sort">Watch</th>
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
            font-size: 13px;
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
    </style>

@endsection
@push('scripts')
    <script src="{{url('themes/data-table/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('js/data-table-localte.js')}}"></script>
    <script src="{{url('themes/data-table/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/adomino-common.js')}}"></script>
    <script src="{{asset('js/modules/auctions.js')}}"></script>
    <script>
        var table;
        var pageLength = 10;
        var type = 'watchlist';
        var sort_order = [[1, 'asc'] ];
        @if ($type == 'active')
        var sort_order = [[2, 'asc']];
        @elseif ($type == 'finished')
        var sort_order = [[2, 'desc']];
        @endif
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
                    url: '{{ route('auction.type',$type) }}',
                },
                columns: [
                    {data: 'domain', name: 'domain'  },
                    {data: 'start_date', name: 'start_date', class: 'text-right', },
                    {data: 'end_date', name: 'end_date', class: 'text-right'},
                    {data: 'start_price', name: 'start_price', class: 'text-right'},
                    {data: 'actual', name: 'actual', class: 'text-right  text-success' ,"type": 'numeric'},
                    {data: 'discount', name: 'discount', class: 'text-right text-success' ,"type": 'numeric'},
                    {data: 'remaining_time', name: 'remaining_time', class: 'text-right text-danger' },
                    {data: 'end_price', name: 'end_price', class: 'text-right', "type": "numeric" },
                    {data: 'offer', name: 'offer', class: 'text-center ',orderable: false, searchable: false, },
                    {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
                ],
                columnDefs: [{
                    orderable: true,
                    targets: 0,
                }],
                "dom": '<"top"<"actions action-btns"B><"action-filters">><"clear">rt<"bottom"<"actions">i{{$type == 'finished' ? '': 'p' }}>',
                "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, 'All']],
                /*order: [[2, 'desc']],*/
                order:sort_order,
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
@endpush
@section('modal')
    @include('customer-portal.layout.modals.customer-auction')
@endsection
