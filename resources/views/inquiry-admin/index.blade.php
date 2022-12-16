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
                        <h3 class="card-title" style="margin-top: 5px;">{{ __('admin-inquiry.title') }}</h3>
                        <a href="{{route('add-new-inquiry')}}" class="btn btn-primary float-right btn-sm">
                            {{ __('admin-inquiry.addNewInquiryButton') }}</a>
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
                                           @if(!empty(session('inquiry_table')) && isset(session('inquiry_table')['search']) && !empty(session('inquiry_table')['search']))
                                           value="{{session('inquiry_table')['search']}}"
                                           @endif
                                           id="yajraSearch" placeholder="Suche">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button data-href="{{route('get-filter-inquiry-modal')}}"
                                        data-id=""
                                        data-name="get-filter-inquiry-modal"
                                        class="btn btn-default float-right OpenModal"><i
                                            class="fa fa-filter"></i>
                                </button>
                                <label data-href="{{route('get-delete-inquiry-modal')}}"
                                       data-id=""
                                       data-name="get-multi-option-modal" style="cursor: pointer"
                                       class="btn btn-default float-right invisible filterButton OpenModal">
                                    <i class="fa fa-trash"></i></label>
                                <label data-href="{{route('get-anonymous-inquiry-modal')}}"
                                       data-id=""
                                       data-name="get-multi-option-modal" style="cursor: pointer"
                                       class="btn btn-default float-right invisible filterButton OpenModal">
                                    {{ __('admin-inquiry.anonymousInquiryButton') }}</label>
                            </div>
                        </div>
                        {{--data-scrollable="true"--}}
                        <table class="table table-striped table-bordered data_table_yajra"
                               data-url="{{route('get-all-inquiries-json')}}"
                               data-table-name="inquiry-table"
                               @if(!empty(session('inquiry_table')) && isset(session('inquiry_table')['filter']) && !empty(session('inquiry_table')['filter']))
                               data-filter="{{session('inquiry_table')['filter']}}"
                               @else
                               data-filter=""
                               @endif
                               @if(!empty(session('inquiry_table')))
                               data-table-show="1"
                               @endif
                               data-custom-order="2"
                               data-custom-sort-type="desc"
                               cellpadding="0"
                               cellspacing="0"
                               @if(!empty(session('inquiry_table')) && isset(session('inquiry_table')['page_length']) && !empty(session('inquiry_table')['page_length']))
                               data-length="{{session('inquiry_table')['page_length']}}"
                               @else
                               data-length="{{$page_length}}"
                               @endif
                               style="display:none;width:100%">
                            <thead>
                            <tr>
                                @foreach($columns as $column_key=>$column_val)
                                    <th class="no-sort" data-column="{{$column_key}}"
                                        @if(isset($column_val['width']))
                                        data-width="{{$column_val['width']}}"
                                        @endif
                                        @if($column_val['name'] == 'Uhrzeit')
                                        style="text-align: right; padding-right: 12px;"
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