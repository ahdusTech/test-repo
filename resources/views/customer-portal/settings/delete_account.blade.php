@extends('customer-portal.layout.customer')
@section('title', 'Delete Account')
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
                        <h3 class="card-title">{{__('customers-sidebar.delete_account')}}</h3>
                    </div>
                    <div class="card-body">
                        {{--<p>{{__('messages.delete_account_message')}}</p>--}}
                        <p>
                            Please note that deleting your bidder account will have the following effects:
                        </p>
                        <ul>
                            <li>You will no longer have access to your bidding account.</li>
                            <li>All data concerning your account will be deleted - except for those that we are legally obligated to retain.</li>
                            <li>A deletion of the customer account is irreversible and therefore irrevocable.</li>
                            <li>You will not be able to re-register with the email address you provided.</li>
                        </ul>
                        <p>                                                                          {{-- {{route('static.dataprivacy')}} --}}
                            You can find more information in our <a class="text-dark" href="#"> <u>Privacy policy</u></a> and in our
                            <a  class="text-dark" href="#"> <u>AGB</u></a>. {{-- {{route('static.agb')}} --}}
                        </p>

                            <p class="mt-3">
                                <button type="button" data-toggle="modal" data-target="#delete_customer_modal"  class="btn btn-primary">Delete account</button>
                            </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="delete_customer_modal"
         tabindex="-1" role="dialog" style="z-index: 99999999999;">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                    <h5 class="modal-title" id="defaultModalLabel">{{__('customers-sidebar.delete_account')}}</h5>
                </div>
                <form action="{{ route('customer.deletion', auth()->guard('customer')->id()) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        @if ($won)
                            <p>Sie können Ihr Konto nicht mehr löschen da Sie bereits eine gewonnene Auktion haben.</p>
                        @elseif($bided)
                            <p>Sie können Ihr Konto derzeit nicht löschen solange Sie noch Teilnehmer einer aktiven Auktion sind.</p>
                        @else
                            <p>{{ __('messages.delete_account_message') }}</p>
                        @endif

                    </div>
                    <div class="modal-footer">
                        @if($delete)
                            <button type="button" class="btn btn-default btn-sm"
                                    data-dismiss="modal">{{ __('admin-users.no') }}</button>
                            <button type="submit" class="btn btn-danger btn-sm">
                                {{ __('admin-users.deleteButton') }}
                            </button>
                        @else
                            <button type="button" class="btn btn-primary btn-sm"
                                    data-dismiss="modal">OK</button>
                        @endif
                       {{-- <button type="button" class="btn btn-default btn-sm"
                                data-dismiss="modal">{{ __('admin-users.no') }}</button>
                        <button type="submit" class="btn btn-danger btn-sm">
                            {{ __('admin-users.deleteButton') }}
                        </button>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
