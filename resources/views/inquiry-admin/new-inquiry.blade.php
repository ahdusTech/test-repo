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
                        <h3 class="card-title">@if(isset($inquiry)) {{ __('admin-inquiry.editInquiryTitle') }} @else {{ __('admin-inquiry.newInquiryTitle') }} @endif </h3>
                    </div>
                    <form method="post"
                          action="@if(isset($inquiry)){{route('update-inquiry-process')}}@else{{route('add-new-inquiry-process')}}@endif">
                        @csrf
                        @if(isset($inquiry))
                            <input type="hidden" name="id" value="{{$inquiry->id}}">
                        @endif
                        <div class="card-body">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-warning">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            <div class="alert-block">  </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.inquiryCreatedInputField') }}
                                    <code>*</code></label>
                                <div class="col-sm-4">
                                    {{--<input type="text" class="form-control datetimepicker-input"--}}
                                    {{--id="dateTimePicker"--}}
                                    {{--data-toggle="datetimepicker" data-target="#dateTimePicker"--}}
                                    {{--@if(isset($inquiry))--}}
                                    {{--value="{{date('m.d.Y H:i',strtotime($inquiry->created_at))}}"--}}
                                    {{--@else value="{{date('m.d.Y H:i')}}" @endif--}}
                                    {{--name="created_at" required/>--}}
                                    {{--<input type="date" class="form-control">--}}
                                    <input type="text" id="datemask"
                                           @if(isset($inquiry))
                                           value="{{date('Y-m-d H:i',strtotime($inquiry->created_at))}}"
                                           class="form-control"
                                           @else value="{{date('Y-m-d H:i')}}" class="form-control created_at_inquiry" @endif
                                           name="created_at"
                                           data-inputmask-alias="datetime"
                                           data-inputmask-inputformat="yyyy-mm-dd HH:mm" data-mask></div>
                                <div class="col-sm-1 mt-1">
                                    <span>(MEZ)</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.domainInputField') }} <code>*</code></label>
                                <div class="col-sm-4">
                                    <input  required
                                            oninput="this.setCustomValidity('')"
                                            oninvalid="this.setCustomValidity('Bitte geben Sie in das Feld etwas ein')"
                                            @if(old('domain'))
                                            value="{{old('domain')}}"
                                            @elseif(isset($inquiry->domain->domain))
                                            value="{{$inquiry->domain->domain}}"
                                            @endif
                                            name="domain"
                                            class="form-control @error('domain') is-invalid @enderror">
                                    {{--<input type="hidden" id="select2_id" name="domain_id"--}}
                                    {{--@if(old('domain_id'))--}}
                                    {{--value='{{old('domain_id')}}'--}}
                                    {{--@elseif(isset($inquiry->domain_id))--}}
                                    {{--value='{{$inquiry->domain_id}}'--}}
                                    {{--@endif>--}}
                                    {{--<input type="hidden" id="select2_text" name="domain_text"--}}
                                    {{--@if(old('domain_text'))--}}
                                    {{--value='{{old('domain_text')}}'--}}
                                    {{--@elseif(isset($inquiry->domain->domain))--}}
                                    {{--value='{{$inquiry->domain->domain}}'--}}
                                    {{--@endif>--}}
                                    {{--<select class="js-select2-ajax form-control @error('domain_id') is-invalid @enderror"--}}
                                    {{--required--}}
                                    {{--data-url="{{route('get-all-domains')}}"></select>--}}
                                    @error('domain')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.genderInputField') }} <code>*</code></label>
                                <div class="col-sm-4">
                                    <select name="gender" required
                                            class="form-control @error('gender') is-invalid @enderror">
                                        {{--<option value="" selected="selected" disabled="disabled">--}}
                                        {{--{{ __('admin-inquiry.genderSelectOptionField') }}--}}
                                        {{--</option>--}}
                                        <option @if(old('gender') && old('gender') == 'm')
                                                selected
                                                @elseif(isset($inquiry->gender) && 'm' == $inquiry->gender)
                                                selected
                                                @endif  value="m">
                                            {{ __('admin-inquiry.mrOptionField') }}
                                        </option>
                                        <option @if(old('gender') && old('gender') == 'f')
                                                selected
                                                @elseif(isset($inquiry->gender) && 'f' == $inquiry->gender)
                                                selected
                                                @endif value="f">
                                            {{ __('admin-inquiry.mrsOptionField') }}
                                        </option>
                                        <option @if(old('gender') && old('gender') == 'i')
                                                selected
                                                @elseif(isset($inquiry->gender) && 'i' == $inquiry->gender)
                                                selected
                                                @endif value="i">
                                            {{ __('admin-inquiry.interestedOptionField') }}
                                        </option>
                                    </select>
                                    @error('gender')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.firstNameInputField') }}</label>
                                <div class="col-sm-4">
                                    <input
                                            @if(old('prename'))
                                            value="{{old('prename')}}"
                                            @elseif(isset($inquiry->prename))
                                            value="{{$inquiry->prename}}"
                                            @endif
                                            name="prename"
                                            class="form-control @error('prename') is-invalid @enderror">
                                    @error('prename')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.LastNameInputField') }}
                                    {{--<code>*</code>--}}</label>
                                <div class="col-sm-4">
                                    <input {{--required
                                           oninput="this.setCustomValidity('')"
                                           oninvalid="this.setCustomValidity('Bitte geben Sie in das Feld etwas ein')"--}}
                                           @if(old('surname'))
                                           value="{{old('surname')}}"
                                           @elseif(isset($inquiry->surname))
                                           value="{{$inquiry->surname}}"
                                           @endif
                                           name="surname"
                                           class="form-control @error('surname') is-invalid @enderror">
                                    @error('surname')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.websiteLanguageInputField') }}
                                    <code>*</code></label>
                                <div class="col-sm-4">
                                    <select class="form-control @error('website_language') is-invalid @enderror"
                                            required name="website_language">
                                        <option value="de"
                                                @if(old('website_language') && old('website_language') == 'de') selected
                                                @elseif(isset($inquiry->website_language) && $inquiry->website_language == 'de') selected @endif>
                                            Deutsch
                                        </option>
                                        <option value="en"
                                                @if(old('website_language') && old('website_language') == 'en"') selected
                                                @elseif(isset($inquiry->website_language) && $inquiry->website_language == 'en') selected @endif>
                                            Englisch
                                        </option>
                                    </select>
                                    @error('website_language')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.browserLanguageInputField') }}</label>
                                <div class="col-sm-4">
                                    <input
                                            @if(old('browser_language'))
                                            value="{{old('browser_language')}}"
                                            @elseif(isset($inquiry->browser_language))
                                            value="{{$inquiry->browser_language}}"
                                            @endif
                                            name="browser_language"
                                            class="form-control @error('browser_language') is-invalid @enderror">
                                    @error('browser_language')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.emailInputField') }}
                                    <code>*</code></label>
                                <div class="col-sm-4">
                                    <input required
                                           oninput="this.setCustomValidity('')"
                                           oninvalid="this.setCustomValidity('Bitte geben Sie in das Feld etwas ein')"
                                           @if(old('email'))
                                           value="{{old('email')}}"
                                           @elseif(isset($inquiry->email))
                                           value="{{$inquiry->email}}"
                                           @endif
                                           name="email"
                                           type="email"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-2 col-form-label">{{ __('admin-inquiry.ipInputField') }}</label>
                                <div class="col-sm-4">
                                    <input
                                            @if(old('ip'))
                                            value="{{old('ip')}}"
                                            @elseif(isset($inquiry->ip))
                                            value="{{$inquiry->ip}}"
                                            @endif
                                            name="ip"
                                            class="form-control @error('ip') is-invalid @enderror">
                                    @error('ip')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="offer_time"
                                   class="col-sm-2 col-form-label">{{ __('admin-inquiry.offerTimeInputField') }}
                                </label>
                                <div class="col-sm-4">
                                      <input type="text" id="offer_time"
                                           @if(isset($inquiry->offer_time))
                                           value="{{date('Y-m-d H:i',strtotime($inquiry->offer_time))}}"
                                           @endif
                                           class="form-control"
                                           name="offer_time"
                                           data-inputmask-alias="datetime"
                                           data-inputmask-inputformat="yyyy-mm-dd HH:mm" data-mask>
                                </div>
                                <div class="col-sm-1 mt-1">
                                    <span>(MEZ)</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="offer_price"
                                   class="col-sm-2 col-form-label">{{ __('admin-inquiry.offerPriceInputField') }}
                                    @if(isset($inquiry->domain->adomino_com_id))
                                        <a href="https://www.adomino.com/admin/index.php?s=dom&ch={{$inquiry->domain->adomino_com_id}}" target="_blank" class="float-right"><img src="{{asset('img/wpage.gif')}}"></a>
                                    @endif

                                </label>
                                <div class="col-sm-4">
                                      <input type="text" id="offer_price"
                                           @if(isset($inquiry->offer_price))  value="{{$inquiry->offer_price}}"  @endif
                                           class="form-control"  name="offer_price" >
                                </div>
                            </div>
                                @if(isset($inquiry))
                                     <div class="form-group row">
                                        <label for="offer_price" class="col-sm-2 col-form-label">   </label>
                                        <div class="col-sm-4">
                                            <button type="button" class="btn btn-primary btn-sm send_offer_modal">
                                                Angebot senden
                                            </button>
                                        </div>
                                    </div>
                                @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                @if(isset($inquiry)) {{ __('admin-inquiry.updateInquiryButton') }} @else {{ __('admin-inquiry.createNewInquiryButton') }}@endif
                            </button>
                            <a href="{{route('inquiry')}}"
                               class="btn btn-default btn-sm float-right filterButton" style="border-color: #dedbdb;">
                                Abbrechen
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.tiny.cloud/1/qne28nf50okw95g9svjc4ejr41829vm4ydpj2rhar30laomm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>

        $(document).ready(function (){
            tinymce.init({
                selector: '#message',
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code  wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat ',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; color:gray;  }'
            });
            @if(isset($inquiry))
                $(document).on('click','.send_offer_modal' , function (){
                    console.log('Send Offer Modal');
                    console.log('selected_lang' , selected_lang);
                    let field_required = 'Feld ist erforderlich';
                    let form_data = new FormData();


                    let offer_price_input = $('#offer_price');
                    let offer_price = offer_price_input.val();
                    if (!offer_price) {
                        offer_price_input.addClass('is-invalid');
                        offer_price_input.next('.error').remove();
                        offer_price_input.after('<small class="text-danger error">'+field_required+'</small>');
                        offer_price_input.focus();
                        return;
                    } else {
                        form_data.append('offer_price', offer_price);
                        offer_price_input.next('.error').remove();
                        offer_price_input.removeClass('is-invalid');
                    }
                    var selected_lang = $('select[name="website_language"]').find(':selected').val();
                    form_data.append('lang', selected_lang);

                    var gender = $('select[name="gender"]').find(':selected').val();
                    form_data.append('gender', gender);

                    var prename = $('input[name="prename"]').val();
                    form_data.append('prename', prename);

                    var surname = $('input[name="surname"]').val();
                    form_data.append('surname', surname);

                    var email = $('input[name="email"]').val();
                    form_data.append('email', email);
                    $.ajax({
                        type: "post",
                        url: '{{ route('admin.create_offer', $inquiry->id) }}',
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: (response) => {
                            if(response.status == 200){
                                $('#send_offer_modal').find('#offer_price').val(offer_price);
                                $('#send_offer_modal').find('#mail_to').val(response.data.mail_to);
                                $('#send_offer_modal').find('#mail_from').val(response.data.mail_from);
                                $('#send_offer_modal').find('#mail_from_email').val(response.data.mail_from_email);
                                $('#send_offer_modal').find('#mail_from_name').val(response.data.mail_from_name);
                                $('#send_offer_modal').find('#bcc').val(response.data.bcc);
                                $('#send_offer_modal').find('#subject').val(response.data.subject);
                                /*$('#send_offer_modal').find('#message').val(response.data.message);*/
                                tinymce.get('message').setContent("<p>"+response.data.message+"</p>");
                                /*tinymce.get('message').setContent("<p>Hello world!</p>");*/
                                $('#send_offer_modal').modal('show');
                            }else if(response.status == 400){
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                $('.alert-block').html('<div class="alert alert-danger">'+response.error+' </div>');
                                setTimeout(function(){
                                    $('.alert-block').find('div').slideUp(500);
                                    location.reload();
                                }, 2000);
                            }



                        },
                        error: (error) => {
                        },
                        beforeSend: () => {
                        },
                        complete: () => {

                        }

                    })
                })
                $(document).on('click','.send_offer_confirm' , function (){
                    console.log('Send Offer Confirm');
                    var form = $('#send_offer_form');
                    $.ajax({
                        type: "post",
                        url: '{{ route('admin.send_offer', $inquiry->id) }}',
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        /*data: form.serialize(),*/
                        data: ({
                            'offer_price': $('#send_offer_form').find('#offer_price').val(),
                            'mail_from_name':  $('#send_offer_form').find('#mail_from_name').val(),
                            'mail_from_email':  $('#send_offer_form').find('#mail_from_email').val(),
                            'mail_to':  $('#send_offer_form').find('#mail_to').val(),
                            'mail_from':  $('#send_offer_form').find('#mail_from').val(),
                            'bcc':  $('#send_offer_form').find('#bcc').val(),
                            'subject':  $('#send_offer_form').find('#subject').val(),
                            'message': tinymce.get('message').getContent()
                        }),
                       /* contentType: false,
                        cache: false,
                        processData: false,*/
                        dataType: 'json',
                        success: (response) => {
                            if(response.status == 200){
                                $('#send_offer_modal').modal('hide');
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                $('.alert-block').html('<div class="alert alert-success">'+response.message+' </div>')
                            }
                            if(response.status == 400){
                                $('.form-alert-block').html('<div class="alert alert-danger">'+response.error+' </div>')
                            }
                            setTimeout(function(){
                                $('.form-alert-block').find('div').slideUp(500);
                                $('.alert-block').find('div').slideUp(500);
                                location.reload();
                            }, 3000);


                        },
                        error: (error) => {
                        },
                        beforeSend: () => {
                        },
                        complete: () => {

                        }

                    })

                })
            @endif
        });
    </script>
@endsection
@section('modals')
    <div class="modal fade" id="send_offer_modal"
         tabindex="-1" role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog modal-xl " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-alert-block">  </div>
                    <form name="send_offer_form" id="send_offer_form">
                        <input type="hidden"  id="offer_price" name="offer_price">
                        <input type="hidden"  id="mail_from_name" name="mail_from_name">
                        <input type="hidden"  id="mail_from_email" name="mail_from_email">
                        <div class="form-group  row mb-0 ">
                            <label for="mail_to" class="col-sm-1 col-form-label">An</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext text-bold" id="mail_to" name="mail_to">
                            </div>
                        </div>
                        <div class="form-group  row mb-0 ">
                            <label for="mail_to" class="col-sm-1 col-form-label">Vor</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext text-bold" id="mail_from" name="mail_from">
                            </div>
                        </div>
                        <div class="form-group  row mb-0 ">
                            <label for="mail_to" class="col-sm-1 col-form-label">Bcc</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext text-bold" id="bcc" name="bcc">
                            </div>
                        </div>
                        <div class="form-group  row ">
                            <label for="mail_to" class="col-sm-1 col-form-label">Betreff</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext text-bold" id="subject" name="subject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <textarea name="message" class="form-control" id="message"  rows="10"> </textarea>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm send_offer_confirm close-button float-right"> Absenden</button>
                </div>

            </div>
        </div>
    </div>
@endsection

