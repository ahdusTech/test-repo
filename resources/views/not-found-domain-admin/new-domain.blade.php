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
                        <h3 class="card-title">@if(isset($domain))
                                {{ __('admin-nfdomain.editdomainTitle') }} @else
                                {{ __('admin-nfdomain.adddomainTitle') }}
                            @endif</h3>
                    </div>
                    <form method="post"
                          action="@if(isset($domain)){{route('update-nfdomain-process')}}@else{{route('add-new-nfdomain-process')}}@endif">
                        @csrf
                        <div class="card-body">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if(isset($domain))
                                <input type="hidden" name="id" value="{{$domain->id}}">
                            @endif
                            <div class="form-group row">
                                <label for="{{ __('admin-nfdomain.createNewDomainCreatedAtInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-nfdomain.createNewDomainCreatedAtInput') }}
                                    <code>*</code></label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="datetime-local" name="created_at"
                                           @if(isset($domain)) value="{{date('Y-m-d',strtotime($domain->created_at))."T".date('H:i:s',strtotime($domain->created_at))}}"
                                           @else value="{{date('Y-m-d')."T".date('H:i:s')}}" @endif>
                                    @error('created_at')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    (Europe/Vienna)
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="{{ __('admin-nfdomain.createNewDomainInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-nfdomain.createNewDomainInput') }}</label>
                                <div class="col-sm-4">
                                    <input class="form-control @error('domain') is-invalid @enderror"
                                           name="domain"
                                           @if(old('domain'))
                                           value="{{old('domain')}}"
                                           @elseif(isset($domain->domain))
                                           value="{{$domain->domain}}"
                                           @endif>
                                    @error('domain')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm float-right">
                                    @if(isset($domain))
                                        {{ __('admin-nfdomain.updateDomainButton') }}
                                    @else
                                        {{ __('admin-nfdomain.createDomainButton') }}
                                    @endif
                                </button>
                                <a href="{{url()->previous()}}"
                                   class="btn btn-default btn-sm float-right filterButton" style="border-color: #797878">
                                    Abbrechen
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection