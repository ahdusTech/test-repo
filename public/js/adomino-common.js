function resetButton(btn) {
    btn.removeClass('disabled');
    btn.removeAttr('disabled', true);
    btn.text(btn.attr('data-original-text'));
}

function showLoaderButton(btn) {
    btn.addClass('disabled');
    btn.attr('disabled', true);
    btn.text(btn.attr('data-loading-text'));
}

$(document).on('click', '.send_code', function(e){
    e.preventDefault();
    var thisB = $(this);
    var url = thisB.attr('data-url');
    console.log('Send code');
    $('.alert-block').html('')
    $.ajax({
        url: url,
        type: 'get',
        dataType: "json",
        success: function (data) {
            /*<strong>'+data.title+'</strong>*/
            $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert"> ' +
                ''+data.message+
                /*'  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> ' +
                '    <span aria-hidden="true">&times;</span>' +
                '  </button> ' +*/
                '</div>');
            console.log('success => ', data);
            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 2000);

        },
        error: function (data) {
            console.log('error => ', data);

        }
    });
})


$(document).on('submit', '#auth-code-form', function(e){
    e.preventDefault();
    var thisB = $(this);
    var url = thisB.attr('data-url');
    console.log('Get TransferOut Code');
    $('.alert-block').html('')
    $('.auth-code-row').html('');
    let domain_input = thisB.find('input[name="domain"]');
    let password_input = thisB.find('input[name="password"]');
    $.ajax({
        url: url,
        type: 'post',
        dataType: "json",
        data: thisB.serialize(),
        success: function (data) {
            console.log('success => ', data);
            if (data.status == 200){
                $('.auth-code-row').html('<div class="col-md-2"> <label>Authcode:</label> </div> <div class="col-md-4"> <tt class="auth-code-number"></tt> '+data.auth_code+'</div>');
            }
            if (data.status == 400){
                $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"> ' +
                    ''+data.error+
                    '</div>');
            }

            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 3000);

        },
        error: function (error) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+error.responseJSON.message  +'</div>');
            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 2000);

            if ((error.responseJSON.hasOwnProperty('errors'))) {
                if (error.responseJSON.errors.hasOwnProperty('domain')) {
                    domain_input.addClass('is-invalid');
                    domain_input.next('.error').remove();
                    domain_input.after('<small class="text-danger error">' + error.responseJSON.errors.domain[0] + '</small>');
                    domain_input.focus();
                    return;
                }
                if (error.responseJSON.errors.hasOwnProperty('password')) {
                    password_input.addClass('is-invalid');
                    password_input.next('.error').remove();
                    password_input.after('<small class="text-danger error">' + error.responseJSON.errors.password[0] + '</small>');
                    password_input.focus();
                    return;
                }
            }
        },beforeSend: () => {
            domain_input.removeClass('is-invalid');
            domain_input.next('.error').remove();

            password_input.removeClass('is-invalid');
            password_input.next('.error').remove();


        },
    });
})

/*calculate_time()*/
function display_time() {

    /*mytime = setTimeout('calculate_time()', refresh)*/
    mytime = setInterval(ajax_time, refresh);
}

function calculate_time() {
    var x =  moment('{{\Carbon\Carbon::now()}}').tz(timezone).format('YYYY-MM-DD h:m:s');
    console.log('x -> momment -> ', x)
    x = new Date(x)
    /*var server_date = '{{\Carbon\Carbon::now()}}';
    console.log('server_date', server_date)
    var x = new Date('{{\Carbon\Carbon::now()}}');
   /!* console.log('x 1', x)*!/*/
    var hours = x.getHours() % 12;
    hours = hours ? hours : 12;
    hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

    var minutes = x.getMinutes().toString()
    minutes = minutes.length == 1 ? 0 + minutes : minutes;

    var seconds = x.getSeconds().toString()
    seconds = seconds.length == 1 ? 0 + seconds : seconds;

    var month = (x.getMonth() + 1).toString();
    month = month.length == 1 ? 0 + month : month;

    var day = x.getDate().toString();
    day = day.length == 1 ? 0 + day : day;

    var x1 = x.getFullYear() + "-" + month + "-" + day;
    x1 = x1 + "&nbsp;&nbsp;&nbsp;" + hours + ":" + minutes + ":" + seconds;
    $('#clock').html(x1);
    display_time();
}

function ajax_time(){

    $.ajax({
        type: 'GET',
        url: clock_url,
        success: (function (data) {
            /* console.log('date data => ', data );*/
            var x = data.date + "&nbsp;&nbsp;&nbsp;" + data.time;
            $('#clock').html(x);
        }),
        dataType: 'json'
    });
}

$(document).on('keyup', '.transfer_out_code1', function(e){
    e.preventDefault();
    e.preventDefault();
    var thisB = $(this);
    var url = thisB.attr('data-url');
    var password = thisB.val()
    console.log('Verify code', password);

    if(password.length == 6){
        $.ajax({
            url: url,
            type: 'get',
            dataType: "json",
            data:{
                'password': password
            },
            success: function (data) {

                if(data.matched){
                    $('.alert-block').html('');
                    $('.auth-code-block').css('display','block');
                    $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert"> ' +
                        '  <strong>'+data.title+'</strong> '+data.message+
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> ' +
                        '    <span aria-hidden="true">&times;</span>' +
                        '  </button> ' +
                        '</div>');
                }else{
                    $('.alert-block').html('');
                    $('.auth-code-block').css('display','none');
                    $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"> ' +
                        '  <strong>'+data.title+'</strong> '+data.message+
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> ' +
                        '    <span aria-hidden="true">&times;</span>' +
                        '  </button> ' +
                        '</div>');
                }
            },
            error: function (data) {
                $('.alert-block').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"> ' +
                    '  <strong>'+data.title+'</strong> '+data.message+
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> ' +
                    '    <span aria-hidden="true">&times;</span>' +
                    '  </button> ' +
                    '</div>');
                $('.auth-code-block').css('display','none');
            }
        });
    }else{
        $('.auth-code-block').css('display','none')
    }

})

function sendAjaxRequest(formData, url, handleData, btn, type="POST") {
    $.ajax({
        url: url,
        type: type,
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            if (btn != undefined && btn != '') {
                // btn.button('loading');
                showLoaderButton(btn)
            }
        },
        success: function (data) {
            if (btn != undefined && btn != '') {
                // btn.button('reset');
                resetButton(btn)
            }
            handleData(data);
        },
        error: function (data) {
            if (data.status !== undefined && data.status === 405) {
                window.location.reload();
            }
            if (btn != undefined && btn != '') {
                // btn.button('reset');
                resetButton(btn)
            }
            handleData(data);
        }
    });
}

function appendFilterInquiryDatas() {
    if ($('.data_table_yajra').length !== undefined) {
        $('select[name="per_page"]').val($('.data_table_yajra').attr('data-length'));
        var filters = $('.data_table_yajra').attr('data-filter');
        if (filters.length > 0) {
            filtersObject = JSON.parse(filters);
            $('input[name="no_of_days"]').val(filtersObject.no_of_days);
            $('select[name="trashed"]').val(filtersObject.trashed);
        }
    }
}

function appendFilterDomainDatas() {
    $('select[name="domain_filter_is_deleted"]').val($('input[name="is_deleted"]').val());
    $('select[name="domain_filter_title"]').val($('input[name="title"]').val());
    $('select[name="domain_filter_info_en"]').val($('input[name="info_en"]').val());
    $('select[name="domain_filter_info_de"]').val($('input[name="info_de"]').val());
}
function countdown_timer(){
    $(document).find('.data-countdown').each(function() {
        /*console.log('Ready data-countdown')*/
        var thisT = $(this);
        var timezone = "Europe/Vienna";
        var date = thisT.data('countdown');
        var seconds = thisT.data('seconds');
        startTimer(seconds, thisT);

    });
}

function startTimer(duration, display) {
    var timer = duration, days, hours, minutes, seconds;
    setInterval(function () {

        days = parseInt(timer / (3600*24), 10);
        hours = parseInt(timer % (3600*24) / 3600, 10);
        minutes = parseInt(timer % 3600 / 60, 10);
        seconds = parseInt(timer % 60, 10);
        if (days){
            if (display.hasClass('auction-overiew-days')) display.addClass('text-success')
        }else{
            if (display.hasClass('auction-overiew-days')) display.addClass('text-danger')

        }
        days = days < 10 ? "0" + days : days;
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        if (display.hasClass('one_day')){
            display.html( hours+ "h:" + minutes+ "m:" + seconds+"s")
            if(timer == 0){
                location.reload();
            }
        }else if(display.hasClass('timer')){
            /*console.log('timer');*/
            display.find('.days').text(days);
            display.find('.hours').text(hours);
            display.find('.minutes').text(minutes);
            display.find('.seconds').text(seconds);
            if(timer == 0){
                location.reload();
            }
        }else {
            display.html(days + "T " + hours+ "h:" + minutes+ "m:" + seconds+"s");

            if(timer == 0){
                if(display.hasClass('auction-overiew-days')){
                    location.reload();
                }else {
                    setInterval(function () {
                        /*table.draw();*/
                        location.reload();
                    }, 1000);

                }

            }
        }

        /*console.log('Remaining Seconds => ', timer)*/
        if(timer == 0){
            duration = timer;
            display.attr('data-seconds', timer)
        }

        if (--timer < 0) {
            /* console.log('duration s => ', duration)*/
            timer = duration;
        }
    }, 1000);
}

function getDataTableLanguage() {
    var language = {
        "sEmptyTable": "Keine Daten in der Tabelle vorhanden",
        "sInfoEmpty": "0 bis 0 von 0 Einträgen",
        "sInfoFiltered": "(gefiltert von _MAX_ Einträgen)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "anzeigen _MENU_ Einträge",
        "sLoadingRecords": "Wird geladen...",
        "sProcessing": "Bitte warten...",
        "sSearch": "Suchen",
        "sZeroRecords": "Keine Einträge vorhanden.",
        "oPaginate": {
            "sFirst": "Erste",
            "sPrevious": "Zurück",
            "sNext": "Nächste",
            "sLast": "Letzte"
        },
        "oAria": {
            "sSortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
            "sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
        }
    };
    if ($('.data_table_yajra_manual').attr('data-total-count') !== undefined || $('.data_table_yajra').attr('data-total-count') !== undefined) {
        if ($('.data_table_yajra_manual').attr('data-total-count') !== undefined)
            language.sInfo = 'Ausgewählt: _TOTAL_ von ' + $('.data_table_yajra_manual').attr('data-total-count') + ' Domains';
        else if ($('.data_table_yajra').attr('data-total-count') !== undefined)
            language.sInfo = 'Ausgewählt: _TOTAL_ von ' + $('.data_table_yajra').attr('data-total-count') + ' Domains';
    } else {
        language.sInfo = "_START_ bis _END_ von _TOTAL_ Einträgen";
    }

    return language;
}

function OpenModal(btn, url, formData, modal_name) {
    modal_name = modal_name || false;
    sendAjaxRequest(formData, url, function (data) {
        console.log('modal data ')
        console.log(data)
        $('#adominoModalContent').html(data.responseText);
        $('#dateRangePicker').daterangepicker()
        $('.singleDatePicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            locale: {
                format: 'DD.MM.YYYY'
            },
            minDate: moment().year() - 10,
            maxDate: moment(),//.subtract(1, "days")
            maxYear: moment().year() + 10,
            // autoUpdateInput: false
        }, function (start, end, label) {
            // $('.singleDatePicker').val(start.format('YYYY/MM/DD'));
        });
        if (modal_name == 'get-filter-inquiry-modal') {
            appendFilterInquiryDatas();
        } else if (modal_name == 'get-filter-domain-modal') {
            appendFilterDomainDatas();
        }
        // if ($('select[name="per_page"]').length !== undefined && $('.data_table_yajra').length !== undefined) {
        //     $('select[name="per_page"]').val($('.data_table_yajra').attr('data-length'));
        // }
        $('#adominoModal').modal();
    }, btn)
}

