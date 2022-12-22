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
                        <h3 class="card-title">
                            {{ __('admin-users.title') }}
                        </h3>
                        <a href="{{route('add-new-user-page')}}"
                           class="btn btn-primary float-right btn-sm">{{ __('admin-users.addUserButton') }}</a>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        {{--<div class="row">--}}
                        {{--<div class="col-md-3">--}}
                        {{--<div class="form-group has-search">--}}
                        {{--<span class="fa fa-search form-control-feedback"></span>--}}
                        {{--<input type="text" class="form-control" id="yajraSearch" placeholder="Suche">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-9">--}}
                        {{--<button data-href="{{route('get-filter-user-modal')}}"--}}
                        {{--data-id=""--}}
                        {{--data-name="get-filter-user-modal"--}}
                        {{--class="btn btn-default float-right OpenModal"><i--}}
                        {{--class="fa fa-filter"></i>--}}
                        {{--</button>--}}
                        {{--<label data-href="{{route('get-delete-user-modal')}}"--}}
                        {{--data-id=""--}}
                        {{--data-name="get-multi-option-modal" style="cursor: pointer"--}}
                        {{--class="btn btn-default float-right invisible filterButton OpenModal">--}}
                        {{--<i class="fa fa-trash"></i></label>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <table class="table table-striped table-bordered data_table_yajra_manual"
                               data-custom-order="1"
                               data-custom-sort-type="asc"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th class="no-sort" style="text-align: right; padding-right: 12px; width: 30px;">#</th>
                                <th style="text-align: right; padding-right: 12px; width: 30px;" class="active_column">ID</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th class="no-sort" style="text-align: center; padding-right: 5px;">2FA Aktiv</th>
                                <th>{{__('admin-users.postion')}}</th>
                                <th class="no-sort">Aktion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><p style="text-align: right;margin: 0px">{{ $loop->index+1 }}</p></td>
                                    <td><p style="text-align: right;margin: 0px">{{$user->id}}</p></td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if(isset($user->loginSecurity->google2fa_enable) && $user->loginSecurity->google2fa_enable == '1')
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;"><i
                                                        class="fa fa-check-circle"
                                                        style="font-size: 20px;color: #67b100;"></i></p>
                                        @else
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;"><i
                                                        class="fa fa-times-circle"
                                                        style="font-size: 20px;color: #ff0000b5;"></i></p>
                                        @endif
                                    </td>
                                    <td>{{$user->position ? __('admin-users.'.$user->position) : ''}}</td>
                                    <td>
                                        <a href="{{route('get-edit-user-page', [$user->id])}}"
                                           style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <label data-href="{{route('get-delete-user-modal')}}"
                                               data-id="{{$user->id}}"
                                               data-name="get-delete-user-modal" style="cursor: pointer"
                                               class="OpenModal"><i class="fa fa-trash"></i></label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
