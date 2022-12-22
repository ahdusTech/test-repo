@extends('layouts.admin')
@section('content')
    <style>
        .dataTables_paginate{
            display: none !important;
        }
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
                        <h3 class="card-title" style="margin-top: 5px;">{{ __('admin-logo.title') }}</h3>
                        <a href="{{route('add-new-logo')}}" class="btn btn-primary float-right btn-sm">
                            {{ __('admin-logo.addNewLogoButton') }}</a>
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
                                <!-- <button data-href="{{route('get-filter-logo-modal')}}"
                                        data-id="" class="btn btn-default float-right OpenModal"><i
                                            class="fa fa-filter"></i>
                                </button> -->
                                <label data-href="{{route('get-delete-logo-modal')}}"
                                       data-id=""
                                       data-name="get-multi-option-modal" style="cursor: pointer"
                                       class="btn btn-default float-right invisible filterButton OpenModal">
                                    <i class="fa fa-trash"></i></label>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered data_table_yajra"
                               data-url="{{route('get-all-logo-json')}}"
                               data-length="{{$page_length}}"
                               data-custom-order="5"
                               data-table-show="1"
                               data-custom-sort-type="asc"
                               data-table-name="logo-table"
                               style="width:100%">
                            <thead>
                            <tr>
                                @foreach($columns as $column_key=>$column_val)
                                    <th data-column="{{$column_key}}"
                                        @if(isset($column_val['type']))
                                        data-custom-type="{{$column_val['type']}}"
                                        @endif
                                        @if($column_val['name'] == 'Logo-ID')
                                        style="text-align: right; padding-right: 12px; width:52px;" 
                                        @endif
                                        @if($column_val['name'] == '#')
                                        style="text-align: right !important; padding-right: 6px; width:20px;"
                                        @endif
                                        @if($column_val['name'] == 'Aktiv?')
                                        style="text-align: center !important; width:50px; padding-left: 12px !important;" 
                                        @endif
                                        @if($column_val['name'] == 'Aktion')
                                        style="width:50px;" 
                                        @endif
                                        @if($column_val['name'] == 'Sortierung')
                                        style="width:70px;"
                                        @endif
                                        @if($column_val['name'] == 'Logo')
                                        style="text-align: center !important; width:120px; padding-left: 12px !important;" 
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