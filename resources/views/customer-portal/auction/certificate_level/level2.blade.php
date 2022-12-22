@extends('customer-portal.layout.customer')
@section('title', 'Auction')
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
                        <h3 class="card-title">Zertifizierung - Level 2</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-block"></div>
                        <div class="row">

                            <div class="col-5">
                                <p class="into_lines">Bitte geben Sie Ihre Rechnungsdaten ein für Ihre Verifizierung ein.</p>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">{{__('auth.customer_registration_form_input_company')}}</label>
                                    <div class="col-sm-8">
                                        <input  type="text" value="{{ auth()->guard('customer')->user()->company }}"
                                                name="company"
                                                id="company"
                                                autofocus
                                                class="form-control @error('company') is-invalid @enderror"  >
                                        @error('company')
                                        <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>

                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">{{__('auth.customer_registration_form_input_road')}}<strong class="text-danger">*</strong>  </label>
                                    <div class="col-sm-8">
                                        <input  type="text" value="{{ auth()->guard('customer')->user()->road }}"
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
                                    <label for="post_code" class="col-sm-2 col-form-label">{{__('auth.customer_registration_form_input_post_code')}} / {{__('auth.customer_registration_form_input_place')}} <strong class="text-danger">*</strong></label>
                                    <div class="col-sm-2">
                                        <input  type="text" value="{{ auth()->guard('customer')->user()->post_code }}"
                                                id="post_code"
                                                name="post_code"
                                                class="form-control @error('post_code') is-invalid @enderror"  >
                                        @error('post_code')
                                        <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>

                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input  type="text" value="{{ auth()->guard('customer')->user()->place }}"
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
                                    <label for="country" class="col-sm-2 col-form-label">{{__('auth.customer_registration_form_input_country')}} <strong class="text-danger">*</strong></label>
                                    <div class="col-sm-8">
                                        <select name="country" id="country" current="{{auth()->guard('customer')->user()->country}}" class="form-control @error('country') is-invalid @enderror">
                                            <option value="">-</option>
                                            @foreach(countries()['top'] as $key => $country)
                                                <option {{ $key == auth()->guard('customer')->user()->country  ? 'selected' : ''}} value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                            <option  style="font-size: 5pt;   " disabled></option>
                                            <option  style="font-size: .2pt;  background-color: lightgray;" disabled></option>
                                            <option  style="font-size: 5pt;   " disabled></option>
                                            @foreach(countries()['normal'] as $key => $country)
                                                <option {{ $key == auth()->guard('customer')->user()->country  ? 'selected' : ''}} value="{{$key}}">{{$country}}</option>
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
                                    <label for="tax_no" class="col-sm-2 col-form-label">UID-Nr <i class="fas fa-info-circle text-success" title="UID-Nummer ist die Abkürzung für Umsatzsteueridentifikationsnummer. Sie dient der eindeutigen Kennzeichnung von Unternehmen, die ihren Sitz in der Europäischen Union haben, und zwar im Sinne des Umsatzsteuerrechts. Sie ist für alle Unternehmen verpflichtend, die im Binnenmarkt Geschäfte tätigen."></i></label>
                                    <div class="col-sm-8">
                                        <input  type="text" value="{{ auth()->guard('customer')->user()->tax_no }}" name="tax_no"  id="tax_no"  class="form-control @error('tax_no') is-invalid @enderror" >
                                        @error('tax_no')
                                        <span class="invalid-feedback error" role="alert">
                                                 <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if(auth()->guard('customer')->user()->is_free_email())
                                <div class="col-7">
                                    <p class="into_lines">
                                        Sie haben bei der Registrierung eine Freemail-Adresse eingegeben. Um in der Auktion bieten zu
                                        können, benötigen Sie jedoch eine E-Mailadresse die keine Freemail-Adresse ist. Bitte geben Sie die
                                        neue E-Mail-Adresse und den per E-Mail empfangenen 6 stelligen PIN-Code nachfolgend ein um die
                                        neue E-Mail-Adresse verifizieren zu können.
                                    </p>

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label"> E-Mail</label>
                                        <div class="col-sm-7">
                                            <input  type="email" value="{{ auth()->guard('customer')->user()->email }}"
                                                    name="email"
                                                    id="email"
                                                    class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                            <span class="invalid-feedback error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">PIN-Code</label>
                                        <div class="col-sm-7">
                                            <input  type="text"   name="pin_code" id="pin_code" class="form-control" placeholder="Per E-Mail empfangenen PIN-Code eingeben">

                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary send_email_verification_code">PIN-Code senden</button>
                                        </div>
                                    </div>

                                </div>
                            @endif

                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="row col-md-12">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="agree_terms" name="agree_terms">
                                    <label class="form-check-label" for="agree_terms">
                                        Ich erkläre mich einverstanden, dass meine Daten elektronisch weiterverarbeitet und gespeichert
                                        werden.<br/>Ihre Daten werden nicht unbefugt an Dritte weitergegeben.
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-primary float-right level_two_submit_btn ">Beantragen</button>
                                <a type="button" href="{{route('customer.auction.certificate')}}" class="btn btn-light float-right mr-1">
                                    Abbrechen
                                </a>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{url('themes/data-table/css/data-table-bootstrap.css')}}">
    <style>
        p.into_lines{
            @if(auth()->guard('customer')->user()->is_free_email())
                height: 100px;
            @else
                height: 30px;
            @endif
        }
    </style>

@endsection
@section('scripts')
    <script>
        $(document).ready(function (){
            $(document).on('click', '.send_email_verification_code', function (e) {
                console.log('send Professional Email verification code');
                let form_data = new FormData();
                let field_required = 'Feld ist erforderlich';
                let email_input = $('#email');
                let email = email_input.val();
                if (!email) {
                    email_input.addClass('is-invalid');
                    email_input.next('.error').remove();
                    email_input.after('<small class="text-danger error">'+field_required+'</small>');
                    email_input.focus();
                    return;
                }else{
                    form_data.append('email', email);
                }


                $.ajax({
                    type: "post",
                    url: '{{ route('customer.level.email_confirmation_code')}}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: (response) => {
                        $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'</div>');
                        console.log('success => ', response);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                        }, 2000);

                    },
                    error: (error) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        if(error.message){
                            $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.message+'</div>');

                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function(){
                                $('.alert-block').find('div').slideUp(500);
                            }, 2000);
                        }else {
                            /*$('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                            setTimeout(function(){
                                $('.alert-block').find('div').slideUp(500);
                            }, 2000);*/

                            if ((error.responseJSON.hasOwnProperty('errors'))) {
                                if (error.responseJSON.errors.hasOwnProperty('email')) {
                                    email_input.addClass('is-invalid');
                                    email_input.next('.error').remove();
                                    email_input.after('<small class="text-danger error">' + error.responseJSON.errors.email[0] + '</small>');
                                    email_input.focus();
                                    return;
                                }
                            }
                        }
                    },
                    beforeSend: () => {
                        email_input.removeClass('is-invalid');
                        email_input.next('.error').remove();
                    },
                    complete: () => {

                    }
                });
            })
            $(document).on('click', '.level_two_submit_btn', function (e) {
                e.preventDefault();
                var thisForm = $(this);
                console.log('Level 2 Submit');

                let form_data = new FormData();

                let tax_no_input = $('#tax_no');
                let company_input = $('#company');
                let road_input = $('#road');
                let post_code_input = $('#post_code');
                let country_select = $('#country');
                let place_input = $('#place');


                let tax_no = tax_no_input.val();
                let company = company_input.val();
                let road = road_input.val();
                let post_code = post_code_input.val();
                let place = place_input.val();
                let country = country_select.find(':selected').val();

                let field_required = 'Feld ist erforderlich';

                /*if (!company) {
                    country_select.addClass('is-invalid');
                    country_select.next('.error').remove();
                    country_select.after('<small class="text-danger error">'+field_required+'</small>');
                    country_select.focus();
                    return;
                }else{
                    form_data.append('company', company);
                }*/
                form_data.append('company', company);
                if (!road) {
                    road_input.addClass('is-invalid');
                    road_input.next('.error').remove();
                    road_input.after('<small class="text-danger error">'+field_required+'</small>');
                    road_input.focus();
                    return;
                }else{
                    form_data.append('road', road);
                }

                if (!post_code) {
                    post_code_input.addClass('is-invalid');
                    post_code_input.next('.error').remove();
                    post_code_input.after('<small class="text-danger error">'+field_required+'</small>');
                    post_code_input.focus();
                    return;
                }else{
                    form_data.append('post_code', post_code);
                }

                if (!place) {
                    place_input.addClass('is-invalid');
                    place_input.next('.error').remove();
                    place_input.after('<small class="text-danger error">'+field_required+'</small>');
                    place_input.focus();
                    return;
                }else{
                    form_data.append('place', place);
                }
                if (!country) {
                    country_select.addClass('is-invalid');
                    country_select.next('.error').remove();
                    country_select.after('<small class="text-danger error">'+field_required+'</small>');
                    country_select.focus();
                    return;
                }else{
                    form_data.append('country', country);
                }
                /*if (!tax_no) {
                    tax_no_input.addClass('is-invalid');
                    tax_no_input.next('.error').remove();
                    tax_no_input.after('<small class="text-danger error">'+field_required+'</small>');
                    tax_no_input.focus();
                    return;
                }else{
                    form_data.append('tax_no', tax_no);
                }*/

                form_data.append('tax_no', tax_no);

                let email_input = $('#email');
                let email = email_input.val();
                if (email_input.length){
                    if (!email) {
                        email_input.addClass('is-invalid');
                        email_input.next('.error').remove();
                        email_input.after('<small class="text-danger error">'+field_required+'</small>');
                        email_input.focus();
                        return;
                    }else{
                        form_data.append('email', email);
                    }
                }
                let pin_code_input = $('#pin_code');
                let pin_code = pin_code_input.val();
                if (pin_code_input.length){
                    if (!pin_code) {
                        pin_code_input.addClass('is-invalid');
                        pin_code_input.next('.error').remove();
                        pin_code_input.after('<small class="text-danger error">'+field_required+'</small>');
                        pin_code_input.focus();
                        return;
                    }else{
                        form_data.append('pin_code', pin_code);
                    }
                }



                let agree_terms_checkbox = $('#agree_terms');
                let agree_terms = agree_terms_checkbox.prop('checked');
                if (!agree_terms){
                    agree_terms_checkbox.addClass('is-invalid');
                    agree_terms_checkbox.next('.error').remove();
                    /*agree_terms_checkbox.after('<small class="text-danger error">'+field_required+'</small>');*/
                    agree_terms_checkbox.css('outline','red auto')
                    agree_terms_checkbox.focus();
                    return;
                }else {
                    form_data.append('terms', 1);
                }




                console.log('ajax');
                $('.preloader').css('display', 'block');
                $.ajax({
                    type: "post",
                    url: '{{ route('customer.level.update_business_details' ) }}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: (response) => {
                        $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'</div>');
                        console.log('success => ', response);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                            setTimeout(function(){
                                window.location.href = '{{route('customer.auction.certificate')}}';
                            }, 100);
                        }, 2000);

                    },
                    error: (error) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('.preloader').css('display', 'none');
                        $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                        }, 2000);
                        if ((error.responseJSON.hasOwnProperty('errors'))) {

                            if (error.responseJSON.errors.hasOwnProperty('tax_no')) {
                                tax_no_input.addClass('is-invalid');
                                tax_no_input.next('.error').remove();
                                tax_no_input.after('<small class="text-danger error">' + error.responseJSON.errors.tax_no[0] + '</small>');
                                tax_no_input.focus();
                                return;
                            }

                            if (error.responseJSON.errors.hasOwnProperty('company')) {
                                company_input.addClass('is-invalid');
                                company_input.next('.error').remove();
                                company_input.after('<small class="text-danger error">' + error.responseJSON.errors.company[0] + '</small>');
                                company_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('road')) {
                                road_input.addClass('is-invalid');
                                road_input.next('.error').remove();
                                road_input.after('<small class="text-danger error">' + error.responseJSON.errors.road[0] + '</small>');
                                road_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('post_code')) {
                                post_code_input.addClass('is-invalid');
                                post_code_input.next('.error').remove();
                                post_code_input.after('<small class="text-danger error">' + error.responseJSON.errors.post_code[0] + '</small>');
                                post_code_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('country')) {
                                country_select.addClass('is-invalid');
                                country_select.next('.error').remove();
                                country_select.after('<small class="text-danger error">' + error.responseJSON.errors.country[0] + '</small>');
                                country_select.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('place')) {
                                place_input.addClass('is-invalid');
                                place_input.next('.error').remove();
                                place_input.after('<small class="text-danger error">' + error.responseJSON.errors.place[0] + '</small>');
                                place_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('pin_code')) {
                                pin_code_input.addClass('is-invalid');
                                pin_code_input.next('.error').remove();
                                pin_code_input.after('<small class="text-danger error">' + error.responseJSON.errors.pin_code[0] + '</small>');
                                pin_code_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('email')) {
                                email_input.addClass('is-invalid');
                                email_input.next('.error').remove();
                                email_input.after('<small class="text-danger error">' + error.responseJSON.errors.email[0] + '</small>');
                                email_input.focus();
                                return;
                            }


                        }
                    },
                    beforeSend: () => {


                        tax_no_input.removeClass('is-invalid');
                        tax_no_input.next('.error').remove();

                        company_input.removeClass('is-invalid');
                        company_input.next('.error').remove();

                        road_input.removeClass('is-invalid');
                        road_input.next('.error').remove();

                        post_code_input.removeClass('is-invalid');
                        post_code_input.next('.error').remove();

                        country_select.removeClass('is-invalid');
                        country_select.next('.error').remove();

                        place_input.removeClass('is-invalid');
                        place_input.next('.error').remove();

                        email_input.removeClass('is-invalid');
                        email_input.next('.error').remove();

                        pin_code_input.removeClass('is-invalid');
                        pin_code_input.next('.error').remove();


                    },
                    complete: () => {

                    }
                });
            })
        });

    </script>
@endsection
