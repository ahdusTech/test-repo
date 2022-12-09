<div class="modal fade" id="delete_customer_auction_modal"
     tabindex="-1" role="dialog" style="z-index: 99999999999;">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                <h5 class="modal-title" id="defaultModalLabel">
                    @if (Route::currentRouteName() === 'customer.auction.watchlist')
                        Beendete Auktion löschen
                    @else
                        Favoriten
                    @endif

                </h5>
            </div>
            <div class="modal-body">
                @if (Route::currentRouteName() === 'customer.auction.watchlist')
                    <p>Wollen Sie die beendete Auktion für die Domain "<span class="wish-list-domain"></span>" wirklich aus der Watchlist unwiderruflich löschen?</p>
                @else
                    <p>Sind Sie sicher, dass Sie die Auktion für die Domain "<span class="wish-list-domain"></span>" aus Ihrer Favoritenliste löschen möchten?</p>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm"
                        data-dismiss="modal">{{ __('admin-users.no') }}</button>
                <button type="button" class="btn btn-danger btn-sm delete-customer-auction-confirm">
                    {{ __('admin-users.deleteButton') }}
                </button>
            </div>

        </div>
    </div>
</div>
