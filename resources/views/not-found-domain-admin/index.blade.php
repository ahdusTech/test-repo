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
                        <h3 class="card-title" style="margin-top: 5px !important;">{{ __('admin-nfdomain.title') }}</h3>
                        <!-- <a href="{{route('add-new-nf-domain')}}" class="btn btn-primary float-right btn-sm">
                            {{ __('admin-nfdomain.addNewDomainButton') }}</a> -->
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
                                    <input type="text"
                                           @if(!empty(session('not_found_table')) && isset(session('not_found_table')['search']) && !empty(session('not_found_table')['search']))
                                           value="{{session('not_found_table')['search']}}"
                                           @endif
                                           class="form-control" id="yajraSearch" placeholder="Suche">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button data-href="{{route('get-filter-nfdomain-modal')}}"
                                        data-id="" class="btn btn-default float-right OpenModal"><i
                                            class="fa fa-filter"></i>
                                </button>
                                <label data-href="{{route('get-delete-nfdomain-modal')}}"
                                       data-id="multi"
                                       data-name="get-multi-option-modal" style="cursor: pointer"
                                       class="btn btn-default float-right filterButton OpenModal">
                                    <i class="fa fa-trash"></i></label>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered data_table_yajra"
                               data-table-show="1"
                               data-custom-order="0"
                               data-custom-sort-type="desc"
                               data-table-name="not-found-domain-table"
                               data-url="{{route('get-all-nfdomains-json')}}"
                               @if(!empty(session('not_found_table')) && isset(session('not_found_table')['page_length']) && !empty(session('not_found_table')['page_length']))
                               data-length="{{session('not_found_table')['page_length']}}"
                               @else
                               data-length="{{$page_length}}"
                               @endif
                               style="width:100%">
                            <thead>
                            <tr>
                                @foreach($columns as $column_key=>$column_val)
                                    <th data-column="{{$column_key}}"
                                        @if($column_val['name'] == 'ID')
                                        style="text-align: right; padding-right: 0px; width: 40px;"
                                        @endif
                                        @if($column_val['name'] == 'Uhrzeit')
                                        style="text-align: right; padding-right: 0px; width: 130px;"
                                        @endif
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