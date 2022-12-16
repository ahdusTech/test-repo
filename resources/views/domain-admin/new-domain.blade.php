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
                                {{ __('admin-domain.editdomainTitle') }} @else
                                {{ __('admin-domain.adddomainTitle') }}
                            @endif</h3>
                    </div>
                    <form method="post"
                          action="@if(isset($domain)){{route('update-domain-process')}}@else{{route('add-new-domain-process')}}@endif">
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
                                <label for="{{ __('admin-domain.createNewDomainInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-domain.createNewDomainInput') }}
                                    <code>*</code></label>
                                <div class="col-sm-4">
                                    <input required class="form-control @error('domain') is-invalid @enderror"
                                           @if(isset($domain->domain)) data-value="{{$domain->domain}}" @endif
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
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainTitleInput') }}"
                                       class="col-sm-2 col-form-label">Domain-Titel</label>
                                <div class="col-sm-4">
                                    <input class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           @if(old('title'))
                                           value="{{old('title')}}"
                                           @elseif(isset($domain->title))
                                           value="{{$domain->title}}"
                                            @endif>
                                    @error('title')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainAdominoComIdInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-domain.createNewDomainAdominoComIdInput') }}</label>
                                <div class="col-sm-4">
                                    <input class="form-control @error('adomino_com_id') is-invalid @enderror"
                                           name="adomino_com_id"
                                           @if(old('adomino_com_id'))
                                           value="{{old('adomino_com_id')}}"
                                           @elseif(isset($domain->adomino_com_id))
                                           value="{{$domain->adomino_com_id}}"
                                            @endif>
                                    @error('adomino_com_id')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainLandingPageModeInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-domain.createNewDomainLandingPageModeInput') }}</label>
                                <div class="col-sm-4">
                                    <select class="form-control @error('landingpage_mode') is-invalid @enderror"
                                            name="landingpage_mode">
                                        <option disabled=""
                                                value="">{{ __('admin-domain.createNewDomainSelectLandingPageModeInput') }}</option>
                                        @foreach($landingpage_mode as $key=>$landingMode)
                                            <option @if(old('landingpage_mode') && old('landingpage_mode') == $key)
                                                    selected
                                                    @elseif(isset($domain->landingpage_mode) && $key == $domain->landingpage_mode)
                                                    selected
                                                    @elseif(!old('landingpage_mode') && !isset($domain->landingpage_mode) && $key == 'request_offer')
                                                    selected
                                                    @endif value="{{$key}}">{{$landingMode}}</option>
                                        @endforeach
                                    </select>
                                    @error('landingpage_mode')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainInfoInput') }}"
                                       class="col-sm-2 col-form-label">Info (de)</label>
                                <div class="col-sm-4">
                                    <textarea name="info_de"
                                              class="form-control @error('info_de') is-invalid @enderror">@if(old('info_de')){{old('info_de')}}@elseif(isset($domain->info_de)){{$domain->info_de}}@endif</textarea>
                                    @error('info_de')
                                    <span class="invalid-feedback error" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainInfoEnInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-domain.createNewDomainInfoEnInput') }}</label>
                                <div class="col-sm-4">
                            <textarea name="info_en"
                                      class="form-control @error('info_en') is-invalid @enderror">@if(old('info_en')){{old('info_en')}}@elseif(isset($domain->info_en)){{$domain->info_en}}@endif</textarea>
                                    @error('info_en')
                                    <span class="invalid-feedback error" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                            @if(session()->has('old_url'))
                                @php($old_url=session()->get('old_url'))
                            @else
                                @php($old_url=url()->previous())
                            @endif
                            <input name="old_url" type="hidden" value="{{$old_url}}"/>
                            <div class="form-group row">
                                <label for="{{ __('admin-domain.createNewDomainBrandableInput') }}"
                                       class="col-sm-2 col-form-label">{{ __('admin-domain.createNewDomainBrandableInput') }}</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" name="brandable"
                                           @if(old('brandable'))
                                           checked
                                           @elseif(isset($domain->brandable) && $domain->brandable)
                                           checked
                                            @endif>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                @if(isset($domain))
                                    {{ __('admin-domain.updateDomainButton') }}
                                @else
                                    {{ __('admin-domain.createDomainButton') }}
                                @endif
                            </button>
                            <a href="{{$old_url}}"
                               class="btn btn-default btn-sm float-right filterButton"
                               style="border-color: #dedbdb;">
                                Abbrechen
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection