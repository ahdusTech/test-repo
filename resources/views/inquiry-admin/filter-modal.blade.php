@extends('layouts.modal-layout')
@section('content')
    <form id="filterInquiryForm" method="post">
        <div class="modal-body">
            <div class="form-group row">
                <label>Gelöschte einbeziehen?</label>
                <select class="form-control" name="trashed">
                    <option value="">Nein</option>
                    <option value="yes">Ja</option>
                    <option value="only">Nur gelöscht</option>
                </select>
            </div>
            <div class="form-group row">
                <label>Pro Seite</label>
                <select class="form-control" name="per_page">
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                    <option selected>500</option>
                    <option>1000</option>
                    <option value="-1">All</option>
                </select>
            </div>
            {{--<div class="form-group row">--}}
                {{--<label>Anzahl der Tage</label>--}}
                {{--<input type="number" class="form-control" name="no_of_days">--}}
            {{--</div>--}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">Abbrechen
            </button>
            <button type="button" class="btn btn-primary btn-sm"
                    id="filterSubmitButton">
                Anwenden
            </button>
        </div>
    </form>
@endsection