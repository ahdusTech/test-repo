@if(isset($big_modal))
    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 700px !important;
            }
        }
    </style>
@endif
<div class="modal fade" id="adominoModal"
     @if(!isset($tabIndexFalse)) tabindex="-1" @endif role="dialog" style="z-index: 99999999999;">
    <div class="modal-dialog @if(isset($big_modal)) modal-lg @endif" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-top: 5px; padding-bottom: 5px;">
                <h5 class="modal-title" id="defaultModalLabel">Kategorie löschen</h5>
            </div>
            @yield('content')
        </div>
    </div>
</div>


