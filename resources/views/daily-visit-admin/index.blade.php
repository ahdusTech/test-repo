@extends('layouts.admin')
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
                        <h3 class="card-title">{{ __('admin-daily-visit.title') }}</h3>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-search input-group">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control"
                                           @if(isset($_REQUEST['search']) && !empty(trim($_REQUEST['search'])))
                                           value="{{trim($_REQUEST['search'])}}"
                                           @endif id="yajraSearch"
                                           placeholder="Suche">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button data-href="{{route('get-filter-daily-visit-modal')}}"
                                        data-id=""
                                        data-name="get-filter-daily-visits-modal"
                                        class="btn btn-default float-right OpenModal"><i
                                            class="fa fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered data_table_yajra"
                               data-url="{{route('get-all-daily-visit-json')}}"
                               data-table-show="1"
                               data-length="{{$page_length}}"
                               data-custom-order="0"
                               data-table-name="daily-visits-table"
                               style="width:100%">
                            <thead>
                            <tr>
                                @foreach($columns as $column_key=>$column_val)
                                    <th data-column="{{$column_key}}"
                                        @if($column_val['name'] == 'Uhrzeit')
                                            style="text-align: right; padding-right: 3px; width: 75px !important;"
                                        @endif
                                        @if($column_val['name'] == 'Domain')
                                            style="width: 300px !important;"
                                        @endif
                                        @if($column_key == 'visits')
                                            style="text-align: right; padding-right: 6px;"
                                        @endif
                                        @if($column_key == 'adomino_com_total')
                                            style="text-align: right; padding-right: 6px;"
                                        @endif
                                        @if($column_key == 'total')
                                            style="text-align: right; padding-right: 6px;"
                                        @endif
                                        @if($column_key == 'adomino_com_ok')
                                            style="text-align: center;"
                                        @endif
                                        @if(!$column_val['sort']) class="no-sort" @endif
                                        data-sort="{{$column_val['sort']}}">{!! $column_val['name'] !!}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection