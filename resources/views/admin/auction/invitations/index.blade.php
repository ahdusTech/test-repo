@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            {{--<div class="container-fluid">

            </div>--}}
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Einladungen senden</h3>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="alert-block">  </div>
                        <div class=" row">
                            <div class="col-md-1">
                                <div class="form-group row">
                                    <label>Geplante Auktion</label>
                                </div>
                            </div>
                            <div class="col-md-10 planned_auction_container">
                                <div class="planned_auction_table_block border">
                                    <table class="table table-striped table-bordered auction-table dataTable "  style="width:100%">
                                        <thead class="d-none">
                                        <tr>
                                            <th  style="min-width: 17%; max-width: 40%; " >Domain</th>
                                            <th style="min-width: 8%; max-width: 15%; text-align: right;">Start</th>
                                            <th style="min-width: 8%; max-width: 15%;  text-align: right;" >Ende</th>
                                            <th style="min-width: 5%;max-width: 8%; text-align: right;" >Tage</th>
                                            <th style="min-width: 8%; max-width: 10%; text-align: right;">Startpreis</th>
                                            <th style="min-width: 6%; max-width: 10%;text-align: right;">Schritt</th>
                                            <th style="text-align: right; min-width: 7%; max-width: 8%;">Endpreis</th>
                                        </tr>
                                        </thead>
                                        <tbody> </tbody>
                                    </table>

                                </div>
                                <p></p>
                            </div>
                            <div class="col-md-1">
                                <button data-toggle="modal" data-target="#include_deleted_auction_modal" class="btn btn-default float-right">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="name" class="col-sm-1 col-form-label">Anlage </label>
                            <div class="col-sm-3 ">
                                <input type="file" class="form-control" name="attachment" id="attachment">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="name" class="col-sm-1 col-form-label">Template </label>
                            <div class="col-sm-3 ">
                                <select name="email_template" id="email_template" class="form-control @error('email_template') is-invalid @enderror">
                                    @foreach($email_templates as $item)
                                        <option data-url="{{route('admin.email_templates',$item->id)}}" value="{{$item->id}}"  {{$item->default ? 'selected':''}}>{{$item->template_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-1 col-form-label"> </label>

                            <div class="col-sm-3 ">
                                <button class="btn btn-primary fetch_related_offers_data">Angebote anzeigen</button>
                            </div>
                        </div>
                        <div class="col-12 invites_table_block d-none">
                            <table class="table table-striped table-bordered invites-table dataTable float-left"  style="width:100%">
                                <thead>
                                    <tr>
                                        <th class=" " style="width: 3%;"  >
                                            <span> <input type="checkbox"  class="select_all_invites" checked style="z-index: 9999;"/></span>
                                        </th>
                                        <th class="no-sort" style="width: 3%;" ></th>
                                        <th class="" style="width: 3%; " >#</th>
                                        <th style="width: 10%; text-align: left;">Anfrage Uhrzeit</th>
                                        <th style="width: 8%;   text-align: left;" >Sprache</th>
                                        <th style="width: 6%;  text-align: left;" >Preis</th>
                                        <th style="width: 6%;  text-align: left;" >Anrede</th>
                                        <th style="width: 12%;  text-align: left;">Varname</th>
                                        <th style="width: 12%; text-align: left;">Nachname</th>
                                        <th style="text-align: left; width: 30%; ">Email</th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-sm float-right d-none send_invite_button"> Senden </button>
                        <a href="{{route('admin.invites')}}"
                           class="btn btn-default btn-sm float-right filterButton" style="border-color: #dedbdb;">
                            Abbrechen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <scrip src="//cdn.datatables.net/plug-ins/1.10.25/sorting/title-numeric.js"></scrip>
    <script>
        var table;
        var invites_table;

        $(document).ready(function (){
             table = $('.auction-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                },
                oLanguage: getDataTableLanguage(),
                ajax: {
                    url: '{{ route('admin.invites') }}',
                    data: function (data) {
                        data.include_deleted = $('#include_deleted').val()
                    },
                },
                columns: [
                    {data: 'domain', name: 'domain',  },
                    {data: 'start_date', name: 'start_date', class: 'text-right', },
                    {data: 'end_date', name: 'end_date', class: 'text-right'},
                    {data: 'days', name: 'days', class: 'text-right' ,"type": 'numeric' },
                    {data: 'start_price', name: 'start_price', class: 'text-right',"type": 'numeric'},
                    {data: 'steps', name: 'steps', class: 'text-right' ,"type": 'numeric'},
                    {data: 'end_price', name: 'end_price', class: 'text-right', "type": "numeric" },
                ],
                columnDefs: [
                    { orderable: true, targets: 0  } ,

                ],
                "dom": '<"top"<"actions action-btns"B><"action-filters">><"clear">rt<"bottom"<"actions">>',
                "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, 'All']],
                order: [[0, 'desc']],
                "pageLength": -1,
                buttons: [ ],
                drawCallback: function (data, callback, settings, json) {

                },
            });

            /*table.columns().iterator('column', function (ctx, idx) {
                if (!$(table.column(idx).header()).hasClass('no-sort')) {
                    if ($(table.column(idx).header())[0].innerHTML.indexOf('sort-icon') === -1) {
                        $(table.column(idx).header()).append('<span class="sort-icon"/>');
                    }
                }
            });*/

            $('#filter_auction_button').click(function () {
                table.draw();
                $('#include_deleted_auction_modal').modal('hide');
            });
            $(document).on('click', '.select_all_invites', function (){
                console.log('select all Invites');
                 if($(this).prop('checked')){
                    $('.invites-table > tbody').find('input[type="checkbox"]').prop('checked', true);
                 }else {
                     $('.invites-table > tbody').find('input[type="checkbox"]').prop('checked', false);
                 }
            });
            $(document).on('click', '.selectIquery', function (){
                if ($('.selectIquery:checked').length == $('.selectIquery').length) {
                    $('.select_all_invites').prop('checked', true);
                }else{
                    $('.select_all_invites').prop('checked', false);
                }
            });

            $(document).on('click', '.auction-table tr.auction-row', function (){
                var thisRow = $(this)
                $('.auction-table tr.auction-row').removeClass('selected');
                console.log('select the planned auction')
                thisRow.toggleClass('selected');
            });






            $(document).on('click', '.fetch_related_offers_data', function (){
                console.log('Fetch Related Offers');
                let planned_auction_table_block = $('.planned_auction_container p');
                let field_required = 'Feld ist erforderlich';
                let auction_selection_message = 'Bitte wählen Sie die Auktion ';

                if($('.auction-table .auction-row.selected').length == 0){
                    planned_auction_table_block.html('<small class="text-danger error">'+auction_selection_message+'</small>');
                    return false;
                }else {
                    planned_auction_table_block.find('.error').remove();
                }
                if ($('.invites-table > tbody tr').length > 0){
                    invites_table.draw();
                }else{
                    invites_listing()
                }
                $('.invites_table_block').removeClass('d-none')

            });


            $(document).on('click', '.send_invite_button', function (){
                console.log('Send Invites to Offered persons');
                let field_required = 'Feld ist erforderlich';
                let form_data = new FormData();
                let auction_id = $('.auction-row.selected').find('.domain_row').attr('auction-id');
                form_data.append('auction_id', auction_id);
                let template_id = $('#email_template').find(':selected').val();
                form_data.append('template_id', template_id);
                var inquery_ids = [];

                $(".selectIquery:checked").each(function(){
                    inquery_ids.push($(this).attr('data-row-id'));
                });
                form_data.append('ids', inquery_ids);

                var files = $('#attachment')[0].files[0];
                if (files) {
                    /*$('#attachment').addClass('is-invalid');
                    $('#attachment').next('.error').remove();
                    $('#attachment').after('<small class="text-danger error">'+field_required+'</small>');
                    $('#attachment').focus();
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return;*/
                    form_data.append('attachment', files);
                } /*else
                    form_data.append('attachment', files);*/

                $.ajax({
                    type: "post",
                    url: '{{ route('admin.inquiries.send-invites') }}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: (response) => {

                        if(response.status == 200){
                            $('#send_offer_modal').modal('hide');
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $('.alert-block').html('<div class="alert alert-success">'+response.message+' </div>')
                        }
                        if(response.status == 400){
                            $('.form-alert-block').html('<div class="alert alert-danger">'+response.error+' </div>')
                        }
                        setTimeout(function(){
                            $('.form-alert-block').find('div').slideUp(500);
                            $('.alert-block').find('div').slideUp(500);
                            location.reload();
                        }, 3000);
                    },
                    error: (error) => {

                    },
                    beforeSend: () => {
                    },
                    complete: () => {

                    }
                });



            });
        });
        function invites_listing(){

            invites_table = $('.invites-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                },
                oLanguage: getDataTableLanguage(),
                ajax: {
                    url: '{{ route('admin.inquiries.sent_offers') }}',
                    data: function (data) {
                        var domains = [];
                        $(document).find('.auction-row.selected').each(function (){
                            var thisRow = $(this);
                            domains.push(thisRow.find('.domain_row').attr('auction-domain'))
                        })
                        var email_template_select = $('#email_template');
                        data.template = email_template_select.find(':selected').val();
                        data.domains = domains;
                    },
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox',  orderable: false, searchable: false, },
                    {data: 'actions', name: 'actions',  orderable: false, searchable: false, },
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-right'},
                    {data: 'created_at', name: 'created_at', class: 'text-center', },
                    {data: 'website_language', name: 'website_language', class: 'text-center'},
                    {data: 'offer_price', name: 'offer_price', class: 'text-right'  },
                    {data: 'gender', name: 'gender', class: 'text-left' },
                    {data: 'prename', name: 'prename', class: 'text-left'  },
                    {data: 'surname', name: 'surname', class: 'text-left'  },
                    {data: 'email', name: 'email', class: 'text-left'  },
                ],
                columnDefs: [
                    { orderable: true, targets: 0  } ,

                ],
                "dom": '<"top"<"actions action-btns"B><"action-filters">><"clear">rt<"bottom"<"actions">>',
                "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, 'All']],
                order: [[3, 'desc']],
                "pageLength": -1,
                buttons: [ ],
                drawCallback: function (data, callback, settings, json) {
                    var recordsTotal = data.json.recordsTotal;
                    console.log(recordsTotal);
                    if (recordsTotal > 0){
                        $('.send_invite_button').removeClass('d-none');
                    }else{
                        $('.send_invite_button').addClass('d-none');
                    }
                },
            });

            invites_table.columns().iterator('column', function (ctx, idx) {
                if (!$(invites_table.column(idx).header()).hasClass('no-sort') && !$(invites_table.column(idx).header()).hasClass('sorting_disabled')) {
                    if ($(invites_table.column(idx).header())[0].innerHTML.indexOf('sort-icon') === -1 ) {
                        $(invites_table.column(idx).header()).append('<span class="sort-icon"/>');
                    }
                }
            });
        }
    </script>
@endsection
@section('css')
    <style>
        .yajrabox-datatable{
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            font-size: 14px !important;
        }
        table.dataTable > thead > tr > th:not(.sorting_disabled), table.dataTable > thead > tr > td:not(.sorting_disabled){
            padding-right: 0px;
        }

        .planned_auction_table_block {
            width: 100%;
            height: 90px;
            overflow: hidden;
            overflow-y: scroll;
            max-height: 90px;
        }
        .planned_auction_table_block table tr:hover{
            cursor: pointer;
        }
        .planned_auction_table_block table tr.selected {
            background: #0c84ff;
            color: white;
        }
    </style>
@endsection
@section('modals')
    <div class="modal fade" id="include_deleted_auction_modal"  tabindex="-1"  role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <h5 class="modal-title" id="defaultModalLabel">Einladungen senden  Filter</h5>
                </div>
                <form id="include_deleted_auction_form" method="post">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Gelöschte einbeziehen ?</label>
                            <select class="form-control" name="include_deleted" id="include_deleted">
                                <option value="no">Nein</option>
                                <option value="yes">Ja</option>
                                {{--<option value="only_deleted">Nur gelöscht</option>--}}

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">Abbrechen
                        </button>
                        <button type="button" class="btn btn-primary btn-sm"
                                id="filter_auction_button">
                            Anwenden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

