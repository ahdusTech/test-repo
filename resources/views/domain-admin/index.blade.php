@extends('layouts.admin')
@section('content')
    <style>
        #DataTables_Table_0_info{
            display: none;
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
                        <h3 class="card-title" style="margin-top: 5px;">{{ __('admin-domain.title') }}</h3>
                        <a href="{{route('add-new-domain')}}" class="btn btn-primary float-right btn-sm">
                            {{ __('admin-domain.addNewDomainButton') }}</a>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="row col-md-12">
                            <span id="selectedInfoSpan"
                                  style="margin-top: -10px; margin-bottom: 10px; font-size: 12px;"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-search input-group">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control"
                                           @if(isset($_REQUEST['search_params']))value="{{$_REQUEST['search_params']}}"
                                           @endif id="yajraSearch" placeholder="Suche">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button data-href="{{route('get-filter-domain-modal')}}"
                                        data-id=""
                                        data-name="get-filter-domain-modal"
                                        class="btn btn-default float-right OpenModal"><i
                                            class="fa fa-filter"></i>
                                </button>
                                <label data-href="{{route('get-delete-domain-modal')}}"
                                       data-id=""
                                       data-name="get-multi-option-modal" style="cursor: pointer"
                                       class="btn btn-default float-right invisible filterButton OpenModal">
                                    <i class="fa fa-trash"></i></label>
                            </div>
                        </div>
                        <input type="hidden" name="info_de"
                               @if(isset($_REQUEST['info_de']))value="{{$_REQUEST['info_de']}}"@endif>
                        <input type="hidden" name="info_en"
                               @if(isset($_REQUEST['info_en']))value="{{$_REQUEST['info_en']}}"@endif>
                        <input type="hidden" name="title"
                               @if(isset($_REQUEST['title']))value="{{$_REQUEST['title']}}"@endif>
                        <input type="hidden" name="is_deleted"
                               @if(isset($_REQUEST['is_deleted']))value="{{$_REQUEST['is_deleted']}}"@endif>
                        <div id="domainLoader" style="display: none">
                            <center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></center>
                        </div>
                        @if(isset($domains))
                            <table class="table table-striped table-bordered data_table_yajra_manual"
                                   data-total-count="<?=$domain_count?>"
                                   {{--@if(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'id')--}}
                                   {{--data-custom-order="1"--}}
                                   {{--@elseif(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain')--}}
                                   {{--data-custom-order="2"--}}
                                   {{--@else--}}
                                   {{--data-custom-order="2"--}}
                                   {{--@endif--}}
                                   {{--@if(isset($_REQUEST['sort_type']) && !empty($_REQUEST['sort_type'])) data-custom-sort-type="{{$_REQUEST['sort_type']}}"--}}
                                   {{--@else data-custom-sort-type="asc" @endif--}}
                                   data-table-name="domains-table"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th class="no-sort"
                                        style="text-align: right; padding-right: 15px; width: 40px !important;">#
                                    </th>
                                    <th style="text-align: right; padding-right: 0px; width: 40px !important;">ID
                                    </th>
                                    <th style="width: 200px !important;"
                                        data-sort="domain"
                                        @if(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain')
                                        data-sort-type="{{$_REQUEST['sort_type']}}"
                                        class="sorting_{{$_REQUEST['sort_type']}} no-sort-custom"
                                        @else data-sort-type="asc" class="sorting no-sort-custom" @endif>
                                        Domain
                                        @if(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain')
                                            @if($_REQUEST['sort_type'] == 'asc')
                                                <img src="https://adomino.net/img/sort_asc.png" style="width: 16px"/>
                                            @elseif($_REQUEST['sort_type'] == 'desc')
                                                <img src="https://adomino.net/img/sort_desc.png" style="width: 16px"/>
                                            @else
                                                <img src="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/images/sort_both.png"
                                                     style="width: 16px"/>
                                            @endif
                                        @else
                                            <img src="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/images/sort_both.png"
                                                 style="width: 16px"/>
                                        @endif
                                    </th>
                                    <th class="no-sort" style="width: 200px !important;">Domain-Titel</th>
                                    <th class="no-sort" style="width: 70px !important;">Info</th>
                                    <th class="no-sort" style="width: 150px !important;">Landingpage-Modus</th>
                                    <th class="no-sort"
                                        style="text-align: center; padding-right: 5px !important; width: 70px !important;">
                                        Brandable
                                    </th>
                                    <th class="no-sort" style="width: 40px !important;">Aktion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                    <tr>
                                        <td><p style="text-align: right;margin: 0px">{{ $loop->index+1 }}</p></td>
                                        <td><p style="text-align: right;margin: 0px">{{$domain->adomino_com_id}}</p>
                                        </td>
                                        <td><a style="color:rgb(0 0 153)" href="http://{{$domain->domain}}"
                                               target="_blank">{{$domain->domain}}</a></td>
                                        <td>{{$domain->title}}</td>
                                        <td>
                                            @php($info="")
                                            @php($info_json=json_decode($domain->info,true))
                                            {{--@if (!empty($domain->getTranslation('info', 'de')))--}}
                                            {{--@php($info.="d")--}}
                                            {{--@endif--}}
                                            {{--@if (!empty($domain->getTranslation('info', 'en')))--}}
                                            {{--@php($info.="e")--}}
                                            {{--@endif--}}
                                            @if (isset($info_json['de']) && !empty($info_json['de']))
                                                @php($info.="d")
                                            @endif
                                            @if (isset($info_json['de']) && !empty($info_json['en']))
                                                @php($info.="e")
                                            @endif

                                            {{$info}}
                                        </td>
                                        <td>{{\App\Domain::getLandingPageMode()[$domain->landingpage_mode]}}</td>
                                        <td>
                                            @if($domain->brandable)
                                                <p style="margin-bottom: 0px; line-height: 0px; text-align: center; margin-left: 10px;">
                                                    <i
                                                            class="fa fa-check"
                                                            style="font-size: 20px;color: #0cbb0cb3;"></i></p>
                                            @else
                                                <p style="margin-bottom: 0px; line-height: 0px; text-align: center; margin-left: 10px;">
                                                    <i
                                                            class="fa fa-minus"
                                                            style="font-size: 10px;color: gray;"></i></p>
                                            @endif
                                        </td>
                                        <td style="line-height: 0px;">
                                            <a href="{{route('edit-domain', [$domain->id])}}"
                                               style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                            <label data-href="{{route('get-delete-domain-modal')}}"
                                                   data-id="{{$domain->id}}"
                                                   data-name="get-delete-inquiry-modal"
                                                   style="cursor: pointer; margin-bottom: 0px;"
                                                   class="OpenModal"><i class="fa fa-trash"></i></label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        {{--<table class="table table-striped table-bordered data_table_yajra"--}}
                        {{--data-url="{{route('get-all-domains-json')}}"--}}
                        {{--data-length="{{(isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page']))?$_REQUEST['per_page']:$page_length}}"--}}
                        {{--data-table-name="domain-table"--}}
                        {{--style="display:none;width:100%">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                        {{--@foreach($columns as $column_key=>$column_val)--}}
                        {{--<th data-column="{{$column_key}}"--}}
                        {{--data-sort="{{$column_val['sort']}}">{!! $column_val['name'] !!}</th>--}}
                        {{--@endforeach--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--</tbody>--}}
                        {{--</table>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection