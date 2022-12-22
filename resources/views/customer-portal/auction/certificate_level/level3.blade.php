@extends('customer-portal.layout.customer')
@section('title', 'Auction')
@section('content')

<style>
        .iti
        {
            display: block !important;
        }
        #error-msg
        {
          color: red;
        }
        #valid-msg
        {
          color: #00C900;
        }
        input.error
        {
          border: 1px solid #FF7C7C;
        }
        .hide
        {
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
                        <h3 class="card-title">Zertifizierung - Level 3</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-block"></div>
                        <div class="col-12">
                            <p class="into_lines col-6">Bitte geben Sie Ihre Mobil-Nr und den per SMS empfangenen 6-stelligen PIN-Code ein um
                                die Zertifizierung für Level 3 abzuschließen.“</p>
                            <!--div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Mobil-Nr <strong class="text-danger">*</strong></label>
                                <div class="col-sm-4">
                                    <select name="phone_code" id="phone_code" class="form-control ">
                                        @include('customer-portal.layout.partials.phone_codes')
                                    </select>
                                </div>
                            </div-->
                            <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Mobil-Nr <strong class="text-danger">*</strong></label>
                                <div class="col-sm-4">
                                <input type="tel" name="phone_number" class="form-control intl-tel-input" id="phone_number" placeholder="" value="" required>
                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                    <span id="error-msg" class="hide"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-4">
                                    <button id="submit" class="btn btn-primary send_phone_verification_code disabled">PIN-Code senden</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">PIN-Code<strong class="text-danger">*</strong></label>
                                <div class="col-sm-4">
                                    <input  type="text"  placeholder="Per SMS empfangenen PIN-Code eingeben" name="pin_code"  id="pin_code"  class="form-control" >
                                </div>
                                {{--<div class="col-sm-2">
                                    <button class="btn btn-primary send_phone_verification_code">PIN-Code senden</button>

                                </div>--}}
                            </div>
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
            height: 80px;
        }
    </style>

@endsection
@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js"></script>
    <script>
        //let phone_code_select = document.querySelector('#phone_code');
        //let phone_number_input = document.querySelector('#phone_number');
        //var input = phone_code_select+phone_number_input;
        var input = document.querySelector("#phone_number");
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Ungültige Nummer", "Ungültiger Ländercode", "Zu kurz", "Zu lang", "Ungültige Nummer"];
        
        var iti = window.intlTelInput(input,
        {
            
            geoIpLookup: function(callback)
            {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp)
                {
                  var countryCode = (resp && resp.country) ? resp.country : "";
                  callback(countryCode);
                });
            },
            initialCountry: 'AT',
            preferredCountries: ['DE','AT','CH'],
            placeholderNumberType: 'MOBILE',
            separateDialCode: true,
            // autoPlaceholder: 'polite',
            hiddenInput: "full_number",
            nationalMode: false,
            autoHideDialCode: false,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js",
        });

        var reset = function() {
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('keyup', function() {
          reset();
          if (input.value.trim()) {
            if (iti.isValidNumber()) {
              validMsg.classList.remove("hide");
              errorMsg.innerHTML = '';
              $('#submit').removeClass('disabled');
            } else {
              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = errorMap[errorCode];
              validMsg.innerHTML = '';
              errorMsg.classList.remove("hide");
              $('#submit').addClass('disabled');
            }
          }
        });


        $("#phone_number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which> 57))
            {
            return false;
            }
        });

        // Removed specail characters on pasting
        $('#phone_number').on('input', function(e) {
            $(this).val(function(i, v) {
            return v.replace(/[^\d]/gi, '');
            });
        });
   
        $(document).ready(function (){
           // $('#phone_code').val('{{ auth()->guard('customer')->user()->phone_code }}')

            $(document).on('click', '.send_phone_verification_code', function (e) {
                var country_code = $(".iti__selected-dial-code").text();
                let form_data = new FormData();
                //let phone_code_select = $('#phone_code');
                let phone_number_input = $('#phone_number');
               //console.log($('#phone_number').intlTelInput("getNumber"));
                //let phone_code = phone_code_select.find(':selected').val();
                let phone_number = phone_number_input.val();
                
                if (phone_number) {
                    // if (!phone_code) {
                    //     phone_code_select.addClass('is-invalid');
                    //     phone_code_select.next('.error').remove();
                    //     phone_code_select.after('<small class="text-danger error">'+field_required+'</small>');
                    //     phone_code_select.focus();
                    //     return;
                    // }else{
                    //     form_data.append('phone_code', phone_code);
                    // }
                    // if (phone_number[0] == 0){
                    //     phone_number_input.addClass('is-invalid');
                    //     phone_number_input.next('.error').remove();
                    //     phone_number_input.after('<small class="text-danger error">Ihre Mobil-Nr darf nicht mit einer 0 beginnen</small>');
                    //     phone_number_input.focus();
                    //     return;
                    // }
                    // if (phone_number.length < 6){
                    //     console.log('phone_number length', phone_number.length)
                    //     phone_number_input.addClass('is-invalid');
                    //     phone_number_input.next('.error').remove();
                    //     phone_number_input.after('<small class="text-danger error">Ihre Mobil-Nr muss mindestens 6 Stellen haben</small>');
                    //     phone_number_input.focus();
                    //     return;
                    // }
                    form_data.append('phone_number', phone_number);
                    form_data.append('phone_code', country_code);
                }
               
                $.ajax({
                    type: "post",
                    url: '{{ route('customer.level.send_verification_code_sms')}}',
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
                        $('#pin_code').focus();
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                            if(response.url){
                                setTimeout(function(){
                                    window.location.href = response.url;
                                }, 100);
                            }

                        }, 2000);

                    },
                    error: (error) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        if(error.message){
                            $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.message+'</div>');
                            console.log('success => ', error);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function(){
                                $('.alert-block').find('div').slideUp(500);
                                if(response.url){
                                    setTimeout(function(){
                                        window.location.href = response.url;
                                    }, 100);
                                }

                            }, 2000);
                        }/*else {
                            $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                            setTimeout(function(){
                                $('.alert-block').find('div').slideUp(500);
                            }, 2000);
                        }*/

                        if ((error.responseJSON.hasOwnProperty('errors'))) {
                            // if (error.responseJSON.errors.hasOwnProperty('phone_code')) {
                            //     phone_code_select.addClass('is-invalid');
                            //     phone_code_select.next('.error').remove();
                            //     phone_code_select.after('<small class="text-danger error">' + error.responseJSON.errors.phone_code[0] + '</small>');
                            //     phone_code_select.focus();
                            //     return;
                            // }
                            if (error.responseJSON.errors.hasOwnProperty('phone_number')) {
                                phone_number_input.addClass('is-invalid');
                                phone_number_input.next('.error').remove();
                                phone_number_input.after('<small class="text-danger error">' + error.responseJSON.errors.phone_number[0] + '</small>');
                                phone_number_input.focus();
                                return;
                            }



                        }
                    },
                    beforeSend: () => {
                        $('#pin_code').focus();
                        //phone_code_select.removeClass('is-invalid');
                        //phone_code_select.next('.error').remove();

                        phone_number_input.removeClass('is-invalid');
                        phone_number_input.next('.error').remove();

                    },
                    complete: () => {

                    }
                });
            })
            $(document).on('click', '.level_two_submit_btn', function (e) {
                console.log('Verify Mobile Phone Number');
                var thisForm = $(this);
                let form_data = new FormData();

                let phone_code = $(".iti__selected-dial-code").text();
                let phone_number_input = $('#phone_number');
                let pin_code_input = $('#pin_code');
                let agree_terms_checkbox = $('#agree_terms');

                //let phone_code = phone_code_select.find(':selected').val();
                let phone_number = phone_number_input.val();
                let pin_code = pin_code_input.val();
                let agree_terms = agree_terms_checkbox.prop('checked');

                let field_required = 'Feld ist erforderlich';
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
                if (phone_number) {
                    if (!phone_code) {
                        phone_code_select.addClass('is-invalid');
                        phone_code_select.next('.error').remove();
                        phone_code_select.after('<small class="text-danger error">'+field_required+'</small>');
                        phone_code_select.focus();
                        return;
                    }else{
                        form_data.append('phone_code', phone_code);
                    }
                    if (phone_number[0] == 0){
                        phone_number_input.addClass('is-invalid');
                        phone_number_input.next('.error').remove();
                        phone_number_input.after('<small class="text-danger error">Ihre Mobil-Nr darf nicht mit einer 0 beginnen</small>');
                        phone_number_input.focus();
                        return;
                    }
                    var numbers = /^[0-9]+$/;
                    if(!phone_number.match(numbers))
                    {
                        phone_number_input.addClass('is-invalid');
                        phone_number_input.next('.error').remove();
                        phone_number_input.after('<small class="text-danger error">Die Telefonnummer darf nur Zahlen enthalten.</small>');
                        phone_number_input.focus();
                        return;
                    }
                    if (phone_number.length < 6){
                        console.log('phone_number length', phone_number.length)
                        phone_number_input.addClass('is-invalid');
                        phone_number_input.next('.error').remove();
                        phone_number_input.after('<small class="text-danger error">Ihre Mobil-Nr muss mindestens 6 Stellen haben</small>');
                        phone_number_input.focus();
                        return;
                    }
                    form_data.append('phone_number', phone_number);
                }

                if (!pin_code) {
                    pin_code_input.addClass('is-invalid');
                    pin_code_input.next('.error').remove();
                    pin_code_input.after('<small class="text-danger error">'+field_required+'</small>');
                    pin_code_input.focus();
                    return;
                }else{
                    form_data.append('pin_code', pin_code);
                }
                console.log('ajax');
                $('.preloader').css('display', 'block');
                $.ajax({
                    type: "post",
                    url: '{{ route('customer.level.verify_mobile_number') }}',
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

                            // if (error.responseJSON.errors.hasOwnProperty('phone_code')) {
                            //     phone_code_select.addClass('is-invalid');
                            //     phone_code_select.next('.error').remove();
                            //     phone_code_select.after('<small class="text-danger error">' + error.responseJSON.errors.phone_code[0] + '</small>');
                            //     phone_code_select.focus();
                            //     return;
                            // }
                            if (error.responseJSON.errors.hasOwnProperty('phone_number')) {
                                phone_number_input.addClass('is-invalid');
                                phone_number_input.next('.error').remove();
                                phone_number_input.after('<small class="text-danger error">' + error.responseJSON.errors.phone_number[0] + '</small>');
                                phone_number_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('pin_code')) {
                                pin_code_input.addClass('is-invalid');
                                pin_code_input.next('.error').remove();
                                pin_code_input.after('<small class="text-danger error">' + error.responseJSON.errors.pin_code[0] + '</small>');
                                pin_code_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('terms')) {
                                agree_terms_checkbox.addClass('is-invalid');
                                agree_terms_checkbox.next('.error').remove();
                                /*agree_terms_checkbox.parent('div').after('<small class="text-danger error">' + error.responseJSON.errors.terms[0] + '</small>');*/
                                agree_terms_checkbox.focus();
                                agree_terms_checkbox.css('outline','red auto')
                                return;
                            }


                        }
                    },
                    beforeSend: () => {


                       // phone_code_select.removeClass('is-invalid');
                        //phone_code_select.next('.error').remove();

                        phone_number_input.removeClass('is-invalid');
                        phone_number_input.next('.error').remove();

                        pin_code_input.removeClass('is-invalid');
                        pin_code_input.next('.error').remove();

                        agree_terms_checkbox.removeClass('is-invalid');
                        agree_terms_checkbox.next('.error').remove();
                        agree_terms_checkbox.css('outline','none')

                    },
                    complete: () => {

                    }
                });
            })
        });

    </script>
@endsection
