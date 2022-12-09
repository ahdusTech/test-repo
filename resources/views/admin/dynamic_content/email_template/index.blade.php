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
                        <h3 class="card-title">E-Mail Templates</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-block"></div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        {{--<div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Template Type </label>
                            <div class="col-sm-4">
                                <select name="email_template" id="email_template" class="form-control @error('email_template') is-invalid @enderror">
                                    @foreach($email_template_types as $item)
                                        <option data-url="{{route('admin.email_templates',$item->type)}}" value="{{$item->type}}" {{isset($template) ? ($template == $item->id ? 'selected':'') : (($item->default ? 'selected':''))}}>{{$item->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary select_email_template">Auswählen</button>
                            </div>
                        </div>--}}
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Template </label>
                            <div class="col-sm-4">
                                <select name="email_template" id="email_template" class="form-control @error('email_template') is-invalid @enderror">
                                    @foreach($email_template_types as $type)
                                        <optgroup label="{{__('admin-email-invitations.types.' . $type->type)}}">
                                            @foreach(\App\Models\Admin\EmailTemplate::where('type', $type->type)->orderBy('order_no','asc')->get() as $item)
                                                <option data-url="{{route('admin.email_templates',$item->id)}}" value="{{$item->id}}" {{isset($template) &&  $template !== '' ? ($template == $item->id ? 'selected':'') : (($item->default ? 'selected':''))}}>{{$item->template_name}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach

                                    {{--@foreach($email_templates as $item)
                                        <option data-url="{{route('admin.email_templates',$item->id)}}" value="{{$item->id}}" {{isset($template) ? ($template == $item->id ? 'selected':'') : (($item->default ? 'selected':''))}}>{{$item->template_name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary select_email_template">Auswählen</button>
                            </div>
                        </div>
                        @if ($email_template)
                            {{--<form action="{{route('admin.email_templates.update', $template)}}" method="post">--}}
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Absender Name <span class="text-danger">*</span> </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="{{$email_template->sender_name ?? ''}}" name="sender_name" id="sender_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Absender E-Mail <span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="{{$email_template->sender_email ?? 'office@adomino.net'}}" name="sender_email" id="sender_email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Bcc E-Mail</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="{{$email_template->bcc ?? 'cc@day.eu'}}" name="bcc" id="bcc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Betreff <span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  value="{{$email_template->email_subject ?? ''}}" name="email_subject" id="email_subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Text <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <textarea name="email_text" class="form-control"  id="email_text" id="text"  rows="12" >{{$email_template->email_text ?? ''}}</textarea>
                                </div>
                                <div class="col-sm-2">
                                    @if($email_template->tags)
                                        @foreach ($email_template->tags as $item)
                                            <p>{{$item}}</p>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"> </div>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-primary update_email_template">Speichern</button>
                                </div>
                            </div>
                            {{-- </form>--}}
                        @endif





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <scrip src="//cdn.datatables.net/plug-ins/1.10.25/sorting/title-numeric.js"></scrip>
    {{--<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>--}}
    {{--<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/inline/ckeditor.js"></script>--}}
    <script src="https://cdn.tiny.cloud/1/qne28nf50okw95g9svjc4ejr41829vm4ydpj2rhar30laomm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>



    <script>
        var table;

        $(document).ready(function (){
           /* InlineEditor
                .create( document.querySelector( '#email_text' ) )
                .catch( error => {
                    console.error( error );
                } );*/
            var emailEditor = tinymce.init({
                selector: '#email_text',
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });

            $('.select_email_template').click(function () {
                var thisSelect = $('#email_template');
                var option = thisSelect.find(':selected').val();
                if(option == 'add_new'){
                    $('#add_email_template_modal').modal('show');
                }else{
                    var url = thisSelect.find(':selected').attr('data-url');
                    window.location = url;
                }
            });


            $(document).on('click', '#save_new_template', function (){
                console.log('Save New Email Template');
                let form_data = new FormData();
                let field_required = 'Feld ist erforderlich';
                let template_name_input = $('#template_name');
                let template_name = template_name_input.val();
                if (!template_name) {
                    template_name_input.addClass('is-invalid');
                    template_name_input.next('.error').remove();
                    template_name_input.after('<small class="text-danger error">'+field_required+'</small>');
                    template_name_input.focus();
                    return;
                } else
                    form_data.append('template_name', template_name);


                let lang_select = $('#lang');
                let lang = lang_select.find(':selected').val();
                if (!lang) {
                    lang_select.addClass('is-invalid');
                    lang_select.next('.error').remove();
                    lang_select.after('<small class="text-danger error">'+field_required+'</small>');
                    lang_select.focus();
                    return;
                } else
                    form_data.append('lang', lang);


                let type_select = $('#type');
                let type = type_select.find(':selected').val();
                if (!type) {
                    type_select.addClass('is-invalid');
                    type_select.next('.error').remove();
                    type_select.after('<small class="text-danger error">'+field_required+'</small>');
                    type_select.focus();
                    return;
                } else
                    form_data.append('type', type);
                $.ajax({
                    type: "post",
                    url: '{{ route('admin.email_templates.save') }}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: (response) => {
                        location.reload();
                    },
                    error: (error) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                        }, 2000);
                        if ((error.responseJSON.hasOwnProperty('errors'))) {
                            if (error.responseJSON.errors.hasOwnProperty('template_name')) {
                                template_name_input.addClass('is-invalid');
                                template_name_input.next('.error').remove();
                                template_name_input.after('<small class="text-danger error">' + error.responseJSON.errors.template_name[0] + '</small>');
                                template_name_input.focus();
                                return;
                            }
                        }
                    },
                    beforeSend: () => {
                        template_name_input.removeClass('is-invalid');
                        template_name_input.next('.error').remove();
                    },
                    complete: () => {

                    }
                });
            });

            $(document).on('click', '.update_email_template', function (){
                console.log('Save New Email Template');
                let form_data = new FormData();
                let field_required = 'Feld ist erforderlich';

                let sender_name_input = $('#sender_name');
                let sender_name = sender_name_input.val();
                if (!sender_name) {
                    sender_name_input.addClass('is-invalid');
                    sender_name_input.next('.error').remove();
                    sender_name_input.after('<small class="text-danger error">'+field_required+'</small>');
                    sender_name_input.focus();
                    return;
                } else
                    form_data.append('sender_name', sender_name);

                let sender_email_input = $('#sender_email');
                let sender_email = sender_email_input.val();
                if (!sender_email) {
                    sender_email_input.addClass('is-invalid');
                    sender_email_input.next('.error').remove();
                    sender_email_input.after('<small class="text-danger error">'+field_required+'</small>');
                    sender_email_input.focus();
                    return;
                } else
                    form_data.append('sender_email', sender_email);

                let email_subject_input = $('#email_subject');
                let email_subject = email_subject_input.val();
                if (!email_subject) {
                    email_subject_input.addClass('is-invalid');
                    email_subject_input.next('.error').remove();
                    email_subject_input.after('<small class="text-danger error">'+field_required+'</small>');
                    email_subject_input.focus();
                    return;
                } else
                    form_data.append('email_subject', email_subject);

                let email_text_input = $('#email_text');
                var email_text = tinymce.get('email_text').getContent();

                /*let email_text = email_text_input.val();*/
                if (!email_text) {
                    email_text_input.addClass('is-invalid');
                    email_text_input.next('.error').remove();
                    email_text_input.after('<small class="text-danger error">'+field_required+'</small>');
                    email_text_input.focus();
                    return;
                } else
                    form_data.append('email_text', email_text);

                let bcc_input = $('#bcc');
                let bcc = bcc_input.val();
                if (bcc) {
                    form_data.append('bcc', bcc);
                }

                $.ajax({
                    type: "post",
                    url: '{{route('admin.email_templates.update', $template)}}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: (response) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('.alert-block').html('<div class="alert alert-success">'+response.message+' </div>')

                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                            location.reload();
                        }, 3000);
                    },
                    error: (error) => {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                        }, 2000);
                        if ((error.responseJSON.hasOwnProperty('errors'))) {
                            if (error.responseJSON.errors.hasOwnProperty('sender_name')) {
                                sender_name_input.addClass('is-invalid');
                                sender_name_input.next('.error').remove();
                                sender_name_input.after('<small class="text-danger error">' + error.responseJSON.errors.sender_name[0] + '</small>');
                                sender_name_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('sender_email')) {
                                sender_email_input.addClass('is-invalid');
                                sender_email_input.next('.error').remove();
                                sender_email_input.after('<small class="text-danger error">' + error.responseJSON.errors.sender_email[0] + '</small>');
                                sender_email_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('bcc')) {
                                bcc_input.addClass('is-invalid');
                                bcc_input.next('.error').remove();
                                bcc_input.after('<small class="text-danger error">' + error.responseJSON.errors.bcc[0] + '</small>');
                                bcc_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('email_subject')) {
                                email_subject_input.addClass('is-invalid');
                                email_subject_input.next('.error').remove();
                                email_subject_input.after('<small class="text-danger error">' + error.responseJSON.errors.email_subject[0] + '</small>');
                                email_subject_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('email_text')) {
                                email_text_input.addClass('is-invalid');
                                email_text_input.next('.error').remove();
                                email_text_input.after('<small class="text-danger error">' + error.responseJSON.errors.email_text[0] + '</small>');
                                email_text_input.focus();
                                return;
                            }
                        }
                    },
                    beforeSend: () => {
                        sender_name_input.removeClass('is-invalid');
                        sender_name_input.next('.error').remove();

                        sender_email_input.removeClass('is-invalid');
                        sender_email_input.next('.error').remove();

                        bcc_input.removeClass('is-invalid');
                        bcc_input.next('.error').remove();

                        email_subject_input.removeClass('is-invalid');
                        email_subject_input.next('.error').remove();

                        email_text_input.removeClass('is-invalid');
                        email_text_input.next('.error').remove();

                    },
                    complete: () => {

                    }
                });
            });
        });
    </script>
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('modals')
    <div class="modal fade" id="add_email_template_modal"  tabindex="-1"  role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <h5 class="modal-title" id="defaultModalLabel">Neue E-Mail-Template hinzufügen</h5>
                </div>
                <form id="add_template_form" method="post">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Template Name</label>
                            <input type="text" class="form-control" name="template_name" id="template_name">
                        </div>
                        <div class="form-group row">
                            <label>Language</label>
                            <select name="lang" id="lang" class="form-control">
                                <option value="de">German</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label>Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="offer">Offer</option>
                                <option value="invitation">Iinvitation</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">Abbrechen
                        </button>
                        <button type="button" class="btn btn-primary btn-sm"
                                id="save_new_template">
                            Speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_auction_modal"
         tabindex="-1" role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <h5 class="modal-title" id="defaultModalLabel">Auktion löschen</h5>
                </div>

                <div class="modal-body">
                    <p>Sind Sie sicher, dass Sie die folgenden Auktion(en) löschen möchten?</p>
                    <p class="domain-list"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm"
                            data-dismiss="modal">{{ __('admin-users.no') }}</button>
                    <button type="button" class="btn btn-danger btn-sm delete-auctions">
                        {{ __('admin-users.deleteButton') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

