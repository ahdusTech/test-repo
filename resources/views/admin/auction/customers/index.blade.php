@extends('layouts.admin')
@section('content')
<style>
    .table td {
        height: 28px !important;
    }

    {{--  .table th {
        width: 33% !important;
    }  --}}
</style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('admin-customers.title') }}
                        </h3>
                        <div class="actions">
                            <a href="javascript:;" data-toggle="modal" data-target="#include_deleted_auction_modal"  class="btn btn-default btn-sm ml-1 float-right">
                                <i class="fa fa-filter"></i>
                            </a>
                            <a href="{{route('admin.customer.create_page')}}" class="btn btn-primary float-right btn-sm">Kunde erstellen</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <table class="table table-striped table-bordered data_table_yajra_manual"
                               data-custom-order="1"
                               data-custom-sort-type="desc"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th class="no-sort" style="text-align: right; padding-right: 12px; width: 4%;">#</th>
                                <th  style="width: 4%; padding-right: 12px; text-align: right;" >{{ __('admin-customers.table_column_id') }}</th>
                                <th style="width: 5%;">{{ __('admin-customers.table_column_title') }}</th>
                                <th style="width: 13%;" >{{ __('admin-customers.table_column_name') }}</th>
                                <th style="width: 13%;">{{ __('admin-customers.table_column_last_name') }}</th>
                                <th style="width: 19% !important;" >{{ __('admin-customers.table_column_email') }}</th>
                                <th style="width: 11% !important; text-align: right; padding-right: 4px;" >Anzahl Fotos</th>
                                {{--  <th class=" "  style="width: 6%; text-align: center;">Domains</th>
                                <th class=" "  style="width: 6%; text-align: center;">Watchlist</th>
                                <th class=" "  style="width: 6%; text-align: center;">Favoriten</th>
                                <th class=" "  style="width: 4%; text-align: center;">Level</th>
                                <th class=" "  style="width: 6%; text-align: center;">Sprache</th> --}}
                                <th class="no-sort" style="text-align: center; padding-right: 5px; width: 10%;">{{ __('admin-customers.table_column_2FA') }}</th>
                                <th class="no-sort" style="width: 5%;">Aktion</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i=11; ?>
                            @foreach($customers as $user)
                                <tr>
                                    <td><p style="text-align: right;margin: 0px">{{ $loop->index+1 }}</p></td>
                                    <td><p style="text-align: right;margin: 0px;">{{$user->id}}</p></td>
                                    <td>{{$user->title ? __('auth.customer_registration_form_input_title_'.$user->title) : ''}}</td>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td style="text-align: right">{{ $i++ }}</td>
                                    {{--  <td class="text-center">{{ $user->domains->count()  }}</td>
                                    <td class="text-center">{{$user->watchlist->count()}}</td>
                                    <td class="text-center">{{$user->favourite->count()}}</td>
                                    <td ><p style="text-align: center;margin: 0px">{{$user->current_level() + (($user->current_level() == 3  && $user->verification_document && !$user->account_approved) ? 1:0)  }} {{(($user->current_level() == 3  && $user->verification_document && !$user->account_approved) ? '+':'')}}</p></td>
                                    <td ><p style="text-align: center;margin: 0px">{{strtoupper($user->lang)}}</p></td> --}}
                                    <td>
                                        @if(isset($user->customer_login_security->google2fa_enable) && $user->customer_login_security->google2fa_enable == '1')
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;"><i
                                                        class="fa fa-check-circle"
                                                        style="font-size: 20px;color: #67b100;"></i></p>
                                        @else
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;"><i
                                                        class="fa fa-times"
                                                        style="font-size: 20px;color: #ff0000b5;"></i></p>

                                        @endif
                                    </td>
                                    <td>
                                            <a href="{{route('admin.customer.edit', [$user->id])}}"
                                               style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;


                                               <a href="{{route('delete-customer-process', [$user->id])}}"
                                                style="cursor: pointer;color: black">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">{{$customers}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="include_deleted_auction_modal"  tabindex="-1"  role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <h5 class="modal-title" id="defaultModalLabel">Kunden-Filter</h5>
                </div>
                <form id="include_deleted_auction_form" action="{{route('admin.customers')}}" method="get">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Gelöschte einbeziehen?</label>
                            <select class="form-control" name="include_deleted" id="include_deleted">
                                <option value="no">Nein</option>
                                <option value="yes">Ja</option>
                                <option value="only_deleted">Nur gelöscht</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">Abbrechen
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm"
                                id="filter_auction_button">
                            Anwenden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
