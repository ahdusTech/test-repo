<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NZ.Photos New Zealand Stockphotos</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet" href="{{url('themes/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/adomino-theme.min.css')}}">
    <link rel="stylesheet" href="{{url('css/adomino.css')}}">

</head>
<body class="hold-transition login-page">
@yield('content')
<script src="{{url('themes/jquery/jquery.min.js')}}"></script>
<script src="{{url('themes/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('js/adomino-theme.min.js')}}"></script>
@stack('scripts')
<script>
    $(document).ready(function (){
        $(document).on('keyup', '#verify_code input[name="password"]', function (){
            console.log('enter password');
            var password = $('#verify_code input[name="password"]');
            password.removeClass('is-invalid');
            password.removeClass('is-valid');
            if(password.val().length < 8){
                password.addClass('is-invalid');
                password.parent('div').next('.custom_validation').remove();
                password.parent('div').after('<small class="text-danger custom_validation error">{{__("auth.password_client_warning_message")}}</small>');


            }else{
                password.addClass('is-valid');
                password.parent('div').next('.custom_validation').remove();
                /*password.parent('div').after('<small class="text-success custom_validation error">{{__("auth.password_client_success_message")}}</small>');*/
            }

        });
        $(document).on('keyup', '#verify_code input[name="password_confirmation"]', function (){
            console.log('enter password');
            var password = $('#verify_code input[name="password"]');
            var password_confirmation = $('#verify_code input[name="password_confirmation"]');

            password_confirmation.removeClass('is-invalid');
            password_confirmation.removeClass('is-valid');
            if(password.val().length === password_confirmation.val().length && password.val() === password_confirmation.val() ){

                password_confirmation.addClass('is-valid');
                password_confirmation.parent('div').next('.custom_validation').remove();
               /* password_confirmation.parent('div').after('<small class="text-success custom_validation error">{{__("auth.password_confirmation_client_success_message")}}</small>');*/


            }else{
                password_confirmation.addClass('is-invalid');
                password_confirmation.parent('div').next('.custom_validation').remove();
                password_confirmation.parent('div').after('<small class="text-danger custom_validation error">{{__("auth.password_confirmation_client_warning_message")}}</small>');

            }

        });

        $(document).on('submit', '#verify_code', function (e){
           /* e.preventDefault()*/
            var thisForm = $(this);
            console.log('verify code');


            var error = 0;
            thisForm.find('select').each(function (){
                var thisS = $(this);
                thisS.removeClass('is-invalid');
                thisS.removeClass('is-valid');
                if (!thisS.find(':selected').val()){
                    error++;
                    thisS.addClass('is-invalid');
                    thisS.parent('div').next('.custom_validation').remove();
                    thisS.parent('div').after('<small class="text-danger custom_validation error">'+thisS.attr('data-message')+'</small>');
                }

            })
            thisForm.find('input').each(function (){
                var thisI = $(this);
                thisI.removeClass('is-invalid');
                thisI.removeClass('is-valid');
                if (!thisI.val()){
                    error++;
                    thisI.addClass('is-invalid');
                    thisI.parent('div').next('.custom_validation').remove();
                    thisI.parent('div').after('<small class="text-danger custom_validation error">'+thisI.attr('data-message')+'</small>');
                }

            })
            if(error){
                e.preventDefault()
            }else {
                thisForm.submit();
            }
        })

        $(document).on('submit', '.customer_reg_form', function (e){
           /* e.preventDefault()*/
            var thisForm = $(this);
            console.log('form submit');
            var error = 0;
            thisForm.find('select').each(function (){
                var thisS = $(this);
                thisS.removeClass('is-invalid');
                thisS.removeClass('is-valid');
                if (!thisS.find(':selected').val()){
                    error++;
                    thisS.addClass('is-invalid');
                    thisS.next('.custom_validation').remove();
                    thisS.after('<small class="text-danger custom_validation error">'+thisS.attr('data-message')+'</small>');
                }

            })
            thisForm.find('input').each(function (){
                var thisI = $(this);
                thisI.removeClass('is-invalid');
                thisI.removeClass('is-valid');
                if (!thisI.val()){
                    error++;
                    thisI.addClass('is-invalid');
                    thisI.next('.custom_validation').remove();
                    thisI.after('<small class="text-danger custom_validation error">'+thisI.attr('data-message')+'</small>');
                }

            })
            if(error){
                e.preventDefault()
            }else {
                thisForm.submit();
            }
        })

        /*$(function () {
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].oninvalid = function (e) {
                    var thisI = $(this);
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.removeClass('is-invalid');
                        e.target.removeClass('is-valid');
                        e.target.addClass('is-valid');
                        e.target.next('.custom_validation').remove();
                        e.target.after('<small class="text-danger custom_validation error">'+e.target.getAttribute("title")+'</small>');
                       /!* e.target.setCustomValidity(e.target.getAttribute("title"));*!/
                    }
                };
            }

            var select = document.getElementsByTagName("select");
            for (var i = 0; i < select.length; i++) {
                select[i].oninvalid = function (e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.setCustomValidity(e.target.getAttribute("title"));
                    }
                };
            }
        });*/
    })
</script>
</body>
</html>
