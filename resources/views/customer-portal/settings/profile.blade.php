@extends('customer-portal.layout.customer')
@section('title', 'Profile')
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
                    <h3 class="card-title"> My Profile </h3>
                </div>
                <form method="post"
                      action="{{ route('admin.customer.update', Auth::guard('customer')->user()->id ) }}">
                    @csrf
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                            <div class="row">
                                <div class="col-md-6">
                                    @if(isset($user))
                                        <input type="hidden" name="id" value="{{Auth::guard('customer')->user()->id}}">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">Kunden-Nr </label>
                                            <div class="col-sm-8">
                                                <input  class="form-control-plaintext" value="{{Auth::guard('customer')->user()->id}}">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Salutation <strong class="text-danger">*</strong></label>
                                        <div class="col-sm-8">
                                            <select name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                                                <option value="">--</option>
                                                <option {{ Auth::guard('customer')->user()->title == 'mr' ? 'selected' : '' }}  value="mr">{{__('auth.customer_registration_form_input_title_mr')}}</option>
                                                <option {{ Auth::guard('customer')->user()->title == 'mrs' ? 'selected' : '' }}  value="mrs">{{__('auth.customer_registration_form_input_title_mrs')}}</option>
                                            </select>
                                            @error('title')
                                            <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-3 col-form-label">First name <strong class="text-danger">*</strong></label>
                                        <div class="col-sm-8">
                                            <input autofocus type="text" value="{{ Auth::guard('customer')->user()->first_name }}"
                                                   name="first_name"
                                                   class="form-control @error('first_name') is-invalid @enderror"   >
                                            @error('first_name')
                                            <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Last name <strong class="text-danger">*</strong></label>
                                        <div class="col-sm-8">
                                            <input autofocus type="text" value="{{ Auth::guard('customer')->user()->last_name }}"
                                                   name="last_name"
                                                   class="form-control @error('last_name') is-invalid @enderror"  >
                                            @error('last_name')
                                            <span class="invalid-feedback error" role="alert">
                                        <!-- <strong>{{ $message }}</strong> -->
                                            <strong>{{__('auth.customer_registration_form_alert_input_last_name')}}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Language <strong class="text-danger">*</strong></label>
                                        <div class="col-sm-8">
                                            <select name="lang" id="lang" class="form-control @error('lang') is-invalid @enderror">
                                                <option value="">--</option>
                                                <option {{ Auth::guard('customer')->user()->lang == 'en' ? 'selected' : '' }} value="en">Englisch</option>
                                                <option {{ Auth::guard('customer')->user()->lang == 'de' ? 'selected' : '' }} value="de">Deutsch</option>
                                            </select>
                                            @error('lang')
                                            <span class="invalid-feedback error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">E-Mail <strong class="text-danger">*</strong> </label>
                                        <div class="col-sm-8">
                                            <input autofocus type="email" value="{{ Auth::guard('customer')->user()->email }}"
                                                   name="email"
                                                   class="form-control @error('email') is-invalid @enderror"  readonly>

                                            @error('email')
                                            <span class="invalid-feedback error" role="alert">
                                         <strong>{{ $message }}</strong>
                                           {{-- <strong>{{__('auth.customer_registration_form_alert_input_email')}}</strong>--}}
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">{{__('admin-customers.password')}} <strong class="text-danger">*</strong></label>
                                        <div class="col-sm-8">
                                            <input autofocus type="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror" value="{{ Auth::guard('customer')->user()->password }}">

                                            @error('password')
                                            <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                                    {{--<strong>{{__('auth.customer_registration_form_alert_input_email')}}</strong>--}}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                        {{--{{$user}}--}}
                                    @if ( isset($user))
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">{{__('admin-customers.login_date')}} </label>
                                            <div class="col-sm-8">

                                                <input  class="form-control-plaintext" disabled value="{{ $user->first_ip ? date_format($user->first_ip->created_at, 'd.m.Y H:i:s') : '-'}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">{{__('admin-customers.login_ip')}} </label>
                                            <div class="col-sm-8">
                                                <input  class="form-control-plaintext" disabled value="{{$user->first_ip ? $user->first_ip->last_login : '-'}}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if(isset($user))
                                    <div class="col-6  justify-content-end">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">{{__('auth.customer_registration_form_input_company')}}</label>
                                            <div class="col-sm-8">
                                                <input  type="text" value="{{ $user->company }}"
                                                        name="company"
                                                        id="company"
                                                        class="form-control @error('company') is-invalid @enderror"  >
                                                @error('company')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>

                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">{{__('auth.customer_registration_form_input_road')}}  </label>
                                            <div class="col-sm-8">
                                                <input  type="text" value="{{ $user->road }}"
                                                        name="road"
                                                        id="road"
                                                        class="form-control @error('road') is-invalid @enderror"  >
                                                @error('road')
                                                <span class="invalid-feedback error" role="alert">
                                               <strong>{{ $message }}</strong>

                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="post_code" class="col-sm-3 col-form-label">{{__('auth.customer_registration_form_input_post_code')}} / {{__('auth.customer_registration_form_input_place')}} </label>
                                            <div class="col-sm-3">
                                                <input  type="text" value="{{ $user->post_code }}"
                                                        id="post_code"
                                                        name="post_code"
                                                        class="form-control @error('post_code') is-invalid @enderror"  >
                                                @error('post_code')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>

                                            </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-5">
                                                <input  type="text" value="{{ $user->place }}"
                                                        id="place"
                                                        name="place"
                                                        class="form-control @error('place') is-invalid @enderror"  >

                                                @error('place')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="country" class="col-sm-3 col-form-label">{{__('auth.customer_registration_form_input_country')}}</label>
                                            <div class="col-sm-8">
                                                <select name="country" id="country" current="{{$user->country}}" class="form-control @error('country') is-invalid @enderror">
                                                    <option value="">-</option>
                                                    @foreach(countries()['top'] as $key => $country)
                                                        <option {{ $key == $user->country  ? 'selected' : ''}} value="{{$key}}">{{$country}}</option>
                                                    @endforeach
                                                    <option  style="font-size: 5pt;" disabled></option>
                                                    <option  style="font-size: .2pt;  background-color: lightgray;" disabled></option>
                                                    <option  style="font-size: 5pt;   " disabled></option>
                                                    @foreach(countries()['normal'] as $key => $country)
                                                        <option {{ $key == $user->country  ? 'selected' : ''}} value="{{$key}}">{{$country}}</option>
                                                    @endforeach

                                                </select>
                                                @error('country')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tax_no" class="col-sm-3 col-form-label">UID-Nr <i class="fas fa-info-circle text-success" title="FAQs"></i></label>
                                            <div class="col-sm-8">
                                                <input  type="text" value="{{ $user->tax_no }}" name="tax_no"  id="tax_no"  class="form-control @error('tax_no') is-invalid @enderror" >
                                                @error('tax_no')
                                                <span class="invalid-feedback error" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-5">
                                            <label for="name" class="col-sm-3 col-form-label">Mobil-Nr</label>
                                            <div class="col-sm-8">
                                                <select name="phone_code" id="phone_code" class="form-control @error('phone_code') is-invalid @enderror">
                                                    @include('customer-portal.layout.partials.phone_codes')
                                                </select>
                                                @error('phone_code')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-8">
                                                <input  type="text"  name="phone_number" id="phone_number" value="{{$user->phone_number}}" class="form-control @error('phone_number') is-invalid @enderror" >
                                                @error('phone_number')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mt-5">
                                            <label for="name" class="col-sm-3 col-form-label">Ausweis</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" readonly value="{{ basename($user->verification_document) }}">
                                                    <div class="input-group-append  ">
                                                    <span class="input-group-text border-0 bg-white text-gray" id="basic-addon1">
                                                        <a href="{{$user->verification_document ? Illuminate\Support\Facades\Storage::url($user->verification_document) : '#'}}" {{$user->verification_document ? 'target="_blank"': ''}}><i class="fas fa-search-plus"></i></a>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label"></label>

                                            <div class="col-sm-8">
                                                <select name="account_approved" id="account_approved" class="form-control @error('account_approved') is-invalid @enderror">
                                                    <option value="" >-</option>
                                                    <option value="1" {{$user->account_approved === 1 ? 'selected' : ''}}>Akzeptiert</option>
                                                    <option value="0" {{$user->account_approved === 0 ? 'selected' : ''}}>Abgelehnt</option>
                                                </select>

                                                @error('account_approved')
                                                <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-right">  Update </button>
                        <a href="{{route('customer.dashboard')}}"
                           class="btn btn-default btn-sm float-right filterButton" style="border-color: #ddd">
                           Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function (){
        @if (isset($user))
            $('#phone_code').val('{{ $user->phone_code }}')
        @endif

    })
</script>

@endsection


