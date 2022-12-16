@extends('layouts.modal-layout')
@section('content')
    <div class="modal-body">
        @if (isset($bids))
            <div class="form-group row">
                {{--<label for="name" class="col-sm-2 col-form-label">{{$domain}}</label>--}}
                <div class="row col-sm-12">
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
                                <tr class="auction-bid-option" data-value="{{$item}}" >
                                    <td >{{number_format($item, 0, ',', '.')}}</td>
                                    <td class="bidder">{{$bidder}}</td>
                                </tr>
                                @php
                                    if (isset($bids) && isset($bids[$item])) {
                                        $bidder = next($bids);
                                    }
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($message))
            <p>{{$message}}</p>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">OK</button>
    </div>

@endsection
