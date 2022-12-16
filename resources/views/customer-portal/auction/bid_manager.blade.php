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
                        <h3 class="card-title">Bietmanager</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert-block"></div>
                        <div class="row">
                            <div class="col-12">
                                <p class="into_lines float-left">
                                    Sie können hier entweder die Domain sofort um den aktuellen Preis kaufen oder können den für Sie passenden niedrigeren
                                    Festpreis angeben um den Sie die Domain kaufen möchten. In diesem Fall wird die Domain, sobald der Preis auf Ihren
                                    angegebenen Preis gesenkt wird, vom Bietmanager automatisch für Sie gekauft. Der Bietschritt dauert in diesem Fall nicht
                                    24 Stunden sondern wird sofort beendet. Es kann nur einen Bieter für jeden der Bietschritte geben. Sie können jederzeit Ihr
                                    Gebot erhöhen, jedoch nicht mehr verringern. Sofern Sie von einem anderen Bieter überboten werden, erhalten Sie von
                                    uns eine Benachrichtigung per E-Mail und können, sofern noch ausreichend Zeit bleibt, Ihr Gebot erhöhen. Bitte beachten
                                    Sie, dass ein anderer Bieter genauso wie Sie ebenfalls die Möglichkeit hat die Domain sofort zu kaufen. In diesem Fall
                                    verliert Ihr niedrigeres Gebot somit an Gültigkeit und die Auktion wird sofort beendet.
                                </p>
                            </div>
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Domain</label>
                                    <div class="col-sm-1"> </div>
                                    <div class="col-sm-4 pl-0">
                                        <input  type="text" value="{{ $auction->domain }}"
                                                class="form-control-plaintext text-bold domain"  disabled >
                                    </div>
                                </div>
                                @if (count($prices) > 0)
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Festpreis Bietschritt</label>
                                        <div class="col-sm-1 text-center">
                                            <div class="form-check">
                                                <input  type="radio" class="form-check-input bid_type bid_type_normal" id="bid_type_normal" name="bid_type" value="normal" checked="checked">
                                            </div>
                                        </div>
                                        <div class="row col-sm-2">
                                            <label class="form-check-label bid_type_normal_label" style="width: 100%"  for="bid_type_normal">
                                                <div class="auction-bid-table border rounded">
                                                    <table class="table" id="actual_price_list" width="100%">
                                                        <tbody>
                                                        @php
                                                            $bidder  = '';
                                                            if (isset($bids)) {
                                                              $bidder = current($bids);
                                                            }

                                                        @endphp
                                                        @foreach ($prices as $index => $item)
                                                            @if (isset($existed_bid_price) && $item < $existed_bid_price)
                                                                <tr class="disabled ad" data-value="{{$item}}" data-instant-price="{{$instant_price}}">
                                                                    <td>  <s>{{number_format($item, 0, ',', '.')}}</s>  </td>
                                                                    <td class="bidder">{{$bidder}}</td>
                                                                </tr>
                                                            @elseif (isset($bids[$item]))
                                                                <tr class="disabled" data-value="{{$item}}" data-instant-price="{{$instant_price}}">
                                                                    <td> <s>{{number_format($item, 0, ',', '.')}}</s> </td>
                                                                    <td class="bidder">{{$bidder}}</td>
                                                                </tr>
                                                            @else
                                                                <tr class="auction-bid-option" data-value="{{$item}}" data-instant-price="{{$instant_price}}">
                                                                    <td >{{number_format($item, 0, ',', '.')}}</td>
                                                                    <td ></td>
                                                                </tr>
                                                            @endif
                                                            @php
                                                                if (isset($bids) && isset($bids[$item])) {
                                                                    $bidder = next($bids);
                                                                }
                                                            @endphp
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </label>
                                            <p class="bid-error"></p>
                                            {{--<select class="form-control " name="actual_price_list" id="actual_price_list" size="7">
                                                @foreach ($prices as $item)
                                                    @if ($current_user_level == 3)
                                                        @if ($item <= 10000)
                                                            <option value="{{$item}}" current-level="{{$current_user_level}}" {{isset($existed_bid_price) ? ($existed_bid_price > $item ? 'disabled':''): ''}} data-instant-price="{{$instant_price}}">{{number_format($item, 0, ',', '.')}} &nbsp; {{}}</option>
                                                        @endif
                                                    @elseif ($current_user_level == 2)
                                                        @if ($item <= 1000)
                                                            <option value="{{$item}}" current-level="{{$current_user_level}}" {{isset($existed_bid_price) ? ($existed_bid_price > $item ? 'disabled':''): ''}} data-instant-price="{{$instant_price}}">{{number_format($item, 0, ',', '.')}}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{$item}}" {{isset($existed_bid_price) ? ($existed_bid_price === $item ? 'disabled':''): ''}} data-instant-price="{{$instant_price}}">{{number_format($item, 0, ',', '.')}}</option>
                                                    @endif


                                                    @if (isset($existed_bid_price) && $item < $existed_bid_price)
                                                        <option value="{{$item}}" {{isset($bids[$item]) ? 'disabled':''}} class=""  data-instant-price="{{$instant_price}}"><s>{{number_format($item, 0, ',', '.')}}</s>&nbsp; {{isset($bids[$item]) ? $bids[$item]:''}}</option>
                                                    @else
                                                        <option value="{{$item}}" {{isset($bids[$item]) ? 'disabled':''}} class=""  data-instant-price="{{$instant_price}}"><s>{{number_format($item, 0, ',', '.')}}</s>&nbsp; {{isset($bids[$item]) ? $bids[$item]:''}}</option>
                                                    @endif

                                                @endforeach
                                            </select>--}}
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    @if ($current_user_level == 3)
                                        @if ($instant_price <= 10000)
                                            <label for="name" class="col-sm-2 col-form-label">Sofortkauf</label>
                                            <div class="col-sm-1 text-center">
                                                <div class="form-check">
                                                    <input  type="radio" class="form-check-input bid_type"  name="bid_type" value="immediately" id="immediately" data-price="{{$instant_price}}" data-price-number="{{number_format($instant_price, 0 , ',', '.')}}">

                                                </div>
                                            </div>
                                            <div class="col-sm-4 row">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="immediately">
                                                        {{number_format($instant_price, 0 , ',', '.')}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                    @elseif ($current_user_level == 2)
                                        @if ($instant_price <= 1000)
                                            <label for="name" class="col-sm-2 col-form-label">Sofortkauf</label>
                                            <div class="col-sm-1 text-center">
                                                <div class="form-check">
                                                    <input  type="radio" class="form-check-input bid_type"  name="bid_type" value="immediately" id="immediately" data-price="{{$instant_price}}" data-price-number="{{number_format($instant_price, 0 , ',', '.')}}">

                                                </div>
                                            </div>
                                            <div class="col-sm-4 row">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="immediately">
                                                        {{number_format($instant_price, 0 , ',', '.')}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                    @else
                                        <label for="name" class="col-sm-2 col-form-label">Sofortkauf</label>
                                        <div class="col-sm-1 text-center">
                                            <div class="form-check">
                                                <input  type="radio" class="form-check-input bid_type"  name="bid_type" value="immediately" id="immediately" data-price="{{$instant_price}}" data-price-number="{{number_format($instant_price, 0 , ',', '.')}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-4 row">
                                            <div class="form-check pl-0">
                                                <label class="form-check-label" for="immediately">
                                                    {{number_format($instant_price, 0 , ',', '.')}}
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <p>
                                            @if ($current_user_level == 3 && $instant_price > 10000)
                                                Wenn Sie mehr als 10.000 EUR bieten wollen, müssen Sie für Level 4 zertifiziert sein.
                                            @elseif ($current_user_level == 2 && $instant_price > 1000)
                                                Wenn Sie mehr als 1.000 EUR bieten wollen, müssen Sie für Level 3 zertifiziert sein.
                                            @endif
                                            Preise in EUR und exkl Ust.

                                        </p>

                                    </div>



                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="row col-md-12 px-0">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="agree_terms" name="agree_terms">
                                    <label class="form-check-label" for="agree_terms">
                                        Ich habe die aktuelle Fassung der <a class="text-dark" href="{{route('static.agb')}}"><u>AGB</u></a> und der
                                        <a class="text-dark"  href="{{route('static.dataprivacy')}}"><u>Datenschutzerklärung</u></a> der DAY Investments Ltd. auf
                                        adomino.net gelesen und akzeptiert. Ich erkläre mich einverstanden, dass meine Daten verarbeitet und
                                        gespeichert werden. Ihre Daten werden nicht unbefugt an Dritte weitergegeben.
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-primary float-right bid-auction-confirm_btn ">Bestätigen</button>
                                <a type="button" href="{{ url()->previous() }}" class="btn btn-light float-right mr-1">
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
           /* min-height: 100px;*/
            margin-bottom: 40px;
        }

        .auction-bid-table {
            width: 100%;
            height: 150px;
            overflow: hidden;
            overflow-y: scroll;
            max-height: 150px;

        }
        .auction-bid-table table {
            height: 120px;
            max-height: 120px;
        }
        .auction-bid-table table tr{
            padding-top:5px;
            padding-bottom:5px;
            cursor: pointer;
        }
        .auction-bid-table table tr.selected{
            background: #0c84ff;
            color: white;
        }
        .auction-bid-table table tr.disabled{
            color: gray;
            cursor: not-allowed;
        }
        .auction-bid-table table td{
            border: none;
        }
        .auction-bid-table table td.bidder{
            color: black;
            font-weight: bold;
        }

    </style>

@endsection

@section('scripts')
    <script src="{{asset('js/modules/auctions.js')}}"></script>
    <script>

        $(document).ready(function (){

            $(document).on('click', '.auction-bid-option', function (){
                var thisTr = $(this);
                console.log('auction-bid-option');
                $('.auction-bid-option').removeClass('selected');
                thisTr.addClass('selected');
                $('#bid_type_normal').attr('checked', true);

            });
            /*$(document).on('change', '#actual_price_list', function (){
                console.log('changed to normal bidding');
                var price_list =  $('#actual_price_list');
                var bid_price = price_list.find(':selected').val();
                $('.bid_type_normal').prop('checked', true);

            })*/
            $(document).on('click', '.bid-auction-confirm_btn', function (){
                var domain = $('.domain').val();
                var bid_type = $('.bid_type:checked').val();
                var price_list =  $('#actual_price_list');
                var bid_error =  $('.bid-error');
                let agree_terms_checkbox = $('#agree_terms');
                let agree_terms = agree_terms_checkbox.prop('checked');

                var message = 'Sind Sie sicher, dass Sie für den Domainnamen';

                if (bid_type == 'normal'){
                   /* var price = price_list.find(':selected').val();*/
                    var price = price_list.find('tr.selected').data('value');
                    if (!price) {
                        price_list.addClass('is-invalid');
                        price_list.next('.error').remove();
                        bid_error.html('<small class="text-danger error">Bitte wählen Sie den Angebotspreis</small>');
                        price_list.focus();
                        return;
                    }else {
                        bid_error.html('');
                        price_list.removeClass('is-invalid');
                    }

                    /*var price_number = $('#actual_price_list').find(':selected').text();*/
                    var price_number = $('#actual_price_list').find('tr.selected td').text();
                    $('.price_confirmation').html('ein Festgebot von <strong>'+price_number+' EUR</strong> EUR (netto) abgeben wollen?')
                }else{
                    message = 'Sind Sie sicher, dass Sie den Domainnamen';
                    var price = $('.bid_type:checked').data('price');
                    var price_number = $('.bid_type:checked').data('price-number');
                    $('.price_confirmation').html('um den Preis von <strong>'+price_number+' EUR</strong> (netto) kaufen wollen?')
                }
                if (!agree_terms){
                    agree_terms_checkbox.addClass('is-invalid');
                    agree_terms_checkbox.next('.error').remove();
                    agree_terms_checkbox.css('outline','red auto')
                    agree_terms_checkbox.focus();
                    return;
                }else {
                    agree_terms_checkbox.removeClass('is-invalid');
                    agree_terms_checkbox.css('outline','none')
                }
                $('.message').text(message);
                $('.domain').text(domain)

                console.log('domain', domain)
                console.log('bid_type', bid_type)
                console.log('price', price)

                $('#confirm_bid_auction_modal').modal('show');
            })
            $(document).on('click', '.submit_bid_auction_button', function (){
                var domain = $('.domain').val();
                var bid_type = $('.bid_type:checked').val();
                if (bid_type == 'normal'){
                    /*var bid_price = $('#actual_price_list').find(':selected').val();*/
                    var bid_price = $('#actual_price_list').find('tr.selected').data('value');
                }else{
                    var bid_price = $('.bid_type:checked').data('price');
                }
                var actual_price = $('.bid_type:checked').data('price');
                var terms = 0;
                let agree_terms_checkbox = $('#agree_terms');
                let agree_terms = agree_terms_checkbox.prop('checked');
                if (!agree_terms){
                    agree_terms_checkbox.addClass('is-invalid');
                    agree_terms_checkbox.next('.error').remove();
                    agree_terms_checkbox.css('outline','red auto')
                    agree_terms_checkbox.focus();
                    return;
                }else {
                    terms = 1;
                }
                $('.submit_bid_auction_button').attr('disabled', true);
                $.ajax({
                    type: "post",
                    url: '{{route('customer.auction.submit_bid', $id)}}',
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    data:{
                        'auction_id': '{{$id}}',
                        'bid_type' : bid_type,
                        'bid_price' : bid_price,
                        'current_price' : actual_price,
                    },
                    success: (response) => {
                        $('.submit_bid_auction_button').attr('disabled', false);
                        $('#confirm_bid_auction_modal').modal('hide');
                        if(response.status == 200){
                            if (bid_type == 'normal'){
                                window.location = '{{route('customer.auction.my', $current_status)}}';
                            }else{
                                window.location = '{{route('customer.auction.my', 'won')}}';
                            }
                        }else {
                            $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'</div>');
                            console.log('success => ', response);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function(){
                                $('.alert-block').find('div').slideUp(500);
                            }, 2000);
                        }

                    },
                    error: (error) => {
                        $('.submit_bid_auction_button').attr('disabled', false);
                    },
                });


            })
            default_bidding_option()
        });

        function default_bidding_option(){
            console.log('default_bidding_option')
            var biding_options = $('.auction-bid-option');
            if(biding_options.length > 0){
                $('#bid_type_normal').attr('checked', true);
                biding_options.first().trigger('click');
            }else {
                $('#immediately').trigger('click');
            }
        }
    </script>
@endsection

