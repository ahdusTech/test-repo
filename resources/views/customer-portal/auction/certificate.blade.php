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
                        <h3 class="card-title">Zertifizierung</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">Wenn Sie die Auktion benutzen wollen, können Sie sich hier für Level 2 bis 4 zertifizieren lassen.</p>

                            <div class="table-holder">
                                <table class="table table-striped auction-table">
                                    <thead>
                                    <tr class="table-active">
                                        <th width="5%" class="text-center">Level</th>
                                        <th width="25%">Möglichkeiten</th>
                                        <th width="35%">Prüfung</th>
                                        <th width="20%">Bearbeitungszeit</th>
                                        <th width="5%">Zertifiziert</th>
                                        <th width="10%" class="text-center">Zertifizieren</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr >
                                        <td class="text-center">1</td>
                                        <td>Nutzung der Favoriten und der Watchlist</td>
                                        <td>Prüfung der E-Mail Gültigkeit bei der Registrierung</td>
                                        <td>Sofort bei Registrierung</td>
                                        <td>
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;">
                                                <i class="fa fa-check" style="font-size: 20px;color: #67b100;"></i>
                                            </p>
                                        </td>
                                        <td class="text-center">-</td>
                                    </tr>
                                    <tr >
                                        <td class="text-center">2</td>
                                        <td>Level 1 und bieten bis 1.000 EUR</td>
                                        <td>Eingabe der Rechnungsdaten, Prüfung das die eingegebene E-Mail keine Freemail Adresse ist</td>
                                        <td>Sofort nach Beantragung</td>
                                        <td>
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;">
                                                @if (auth()->guard('customer')->user()->current_level() >= 2)
                                                    <i class="fa fa-check" style="font-size: 20px;color: #67b100;"></i>
                                                @else
                                                    <i class="fa fa-times" style="font-size: 20px;color: #ff0000b5;"></i>
                                                @endif

                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->guard('customer')->user()->current_level() == 1)
                                                <a href="{{route('customer.auction.level', 2)}}">
                                                    <button class=" btn btn-success btn-sm">Beantragen</button>
                                                </a>
                                            @elseif (auth()->guard('customer')->user()->current_level() > 1)
                                                -
                                            @endif

                                        </td>
                                    </tr>
                                    <tr >
                                        <td class="text-center">3</td>
                                        <td>Level 2 und bieten bis 10.000 EUR</td>
                                        <td>Prüfung der Handynummer durch SMS-Versand</td>
                                        <td>Sofort nach Beantragung</td>
                                        <td >
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;">
                                                @if (auth()->guard('customer')->user()->current_level() >= 3)
                                                    <i class="fa fa-check" style="font-size: 20px;color: #67b100;"></i>
                                                @else
                                                    <i class="fa fa-times" style="font-size: 20px;color: #ff0000b5;"></i>
                                                @endif

                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->guard('customer')->user()->current_level() == 2)
                                                <a href="{{route('customer.auction.level', 3)}}">
                                                    <button class=" btn btn-success btn-sm">Beantragen</button>
                                                </a>
                                            @elseif (auth()->guard('customer')->user()->current_level() > 2)
                                                -
                                            @endif


                                        </td>
                                    </tr>
                                    <tr >
                                        <td class="text-center">4</td>
                                        <td>Level 3 und bieten ohne Limit</td>
                                        <td>Prüfung eines Ausweises (Reisepass oder Führerschein) des Kunden</td>
                                        <td>1-3 Werktage</td>
                                        <td>
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;">
                                            <p style="line-height:0px; margin-bottom:0px;text-align: center;">
                                                @if (auth()->guard('customer')->user()->current_level() >= 4)
                                                    <i class="fa fa-check" style="font-size: 20px;color: #67b100;"></i>
                                                @else
                                                    <i class="fa fa-times" style="font-size: 20px;color: #ff0000b5;"></i>
                                                @endif

                                            </p>
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if (auth()->guard('customer')->user()->current_level() == 3 && !auth()->guard('customer')->user()->verification_document)
                                                <a href="{{route('customer.auction.level', 4)}}">
                                                    <button class=" btn btn-success btn-sm">Beantragen</button>
                                                </a>

                                            @elseif (auth()->guard('customer')->user()->current_level() == 3 && auth()->guard('customer')->user()->verification_document )
                                                Beantragt
                                            @elseif (auth()->guard('customer')->user()->current_level() == 4)
                                                -
                                            @endif
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
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
        .table-holder{
            padding: 0;
            width: 100%;
            color: black;
        }
        .table-holder .table tr.table-active{
            background-color: #00000026 !important;

        }
        .table-holder .table tr:nth-child(odd){
            background-color: white;
        }
        .table-holder .table tr:nth-child(even){
            background-color: #0000000d;
        }

        .table-holder .table th, .table-holder  .table td{
            padding: 10px 5px  !important;
            font-size: 16px;
        }
        .table-holder .table th{
            font-weight: 600;
        }
        .table-holder .table td{
            /*font-weight: 500;*/
        }
        .table-holder tfoot a{
            color: #0b2e13;
            text-decoration: underline ;
        }


        .table-holder .btn-sm{
            padding: 2px 10px;
            font-size: 16px;
        }
        .table-holder .table th{
            border-bottom: 1px solid black;
            border-right: 1px solid black;
        }
        .table-holder .table td{
            border-right: 1px solid black;
        }
        .table-holder .table td:last-child{
            border-right: 0;
        }
        .table-holder .table th:last-child{
            border-right: 0;
        }

        .domain:hover{
            text-decoration: underline;
        }
    </style>

@endsection
