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
                        <h3 class="card-title">Zertifizierung - Level 4</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-block"></div>
                        <div class="col-12">
                            <p  class="into_lines col-6">Bitte laden Sie entweder Ihren Reisepass oder Führerschein im PDF oder JPG Format auf
                                unseren Server um die Zertifizierung für Level 4 abzuschließen. Die Bearbeitungszeit beträgt
                                1-3 Werktage. Sie werden nach erfolgter Prüfung per E-Mail informiert.</p>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Dokument<strong class="text-danger">*</strong></label>
                                <div class="col-sm-4">
                                    <input  type="file"  name="document"  id="document"  class="form-control" accept="image/jpg,application/pdf">
                                </div>
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
                                <button type="button" class="btn btn-primary float-right level_four_submit_btn ">Beantragen</button>
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
    <script>
        $(document).ready(function (){


            $(document).on('click', '.level_four_submit_btn', function (e) {
                console.log('Verify Mobile Phone Number');
                var thisForm = $(this);
                let form_data = new FormData();

                let document_input = $('#document');
                let agree_terms_checkbox = $('#agree_terms');

                let agree_terms = agree_terms_checkbox.prop('checked');

                let field_required = 'Feld ist erforderlich';
                if (!agree_terms){
                    agree_terms_checkbox.addClass('is-invalid');
                    agree_terms_checkbox.next('.error').remove();
                    /*agree_terms_checkbox.parent('div').after('<small class="text-danger error">'+field_required+'</small>');*/
                    agree_terms_checkbox.focus();
                    agree_terms_checkbox.add().css('outline','red auto')
                    return;
                }else {
                    form_data.append('terms', 1);
                }


                if (!document_input[0].files[0]) {
                    document_input.addClass('is-invalid');
                    document_input.next('.error').remove();
                    document_input.after('<small class="text-danger error">'+field_required+'</small>');
                    document_input.focus();
                    return;
                }else{
                    form_data.append('document', document_input[0].files[0]);
                }
                console.log('ajax');
                $('.preloader').css('display', 'block');
                $.ajax({
                    type: "post",
                    url: '{{ route('customer.level.upload_document') }}',
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
                        /*$('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
                        setTimeout(function(){
                            $('.alert-block').find('div').slideUp(500);
                        }, 2000);*/
                        if ((error.responseJSON.hasOwnProperty('errors'))) {

                            if (error.responseJSON.errors.hasOwnProperty('document')) {
                                document_input.addClass('is-invalid');
                                document_input.next('.error').remove();
                                document_input.after('<small class="text-danger error">' + error.responseJSON.errors.document[0] + '</small>');
                                document_input.focus();
                                return;
                            }
                            if (error.responseJSON.errors.hasOwnProperty('terms')) {
                                agree_terms_checkbox.addClass('is-invalid');
                                agree_terms_checkbox.next('.error').remove();
                                agree_terms_checkbox.parent('div').after('<small class="text-danger error">' + error.responseJSON.errors.terms[0] + '</small>');
                                agree_terms_checkbox.focus();
                                return;
                            }



                        }
                    },
                    beforeSend: () => {
                        document_input.removeClass('is-invalid');
                        document_input.next('.error').remove();

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
