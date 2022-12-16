@extends('layouts.modal-layout')
@section('content')
    <form id="filterDomainForm" method="post">
        <div class="modal-body">
            <div class="form-group row">
                <label>Info-Text (DE) vorhanden?</label>
                <select name="domain_filter_info_de" class="form-control filterInput">
                    <option value="">Egal</option>
                    <option value="yes">Ja</option>
                    <option value="no">Nein</option>
                </select>
            </div>
            <div class="form-group row">
                <label>Info-Text (EN) vorhanden?</label>
                <select name="domain_filter_info_en" class="form-control filterInput">
                    <option value="">Egal</option>
                    <option value="yes">Ja</option>
                    <option value="no">Nein</option>
                </select>
            </div>
            <div class="form-group row">
                <label>Titel vorhanden?</label>
                <select name="domain_filter_title" class="form-control filterInput">
                    <option value="">Egal</option>
                    <option value="yes">Ja</option>
                    <option value="no">Nein</option>
                </select>
            </div>
            <div class="form-group row">
                <label>Gelöschte einbeziehen?</label>
                <select name="domain_filter_is_deleted" class="form-control filterInput">
                    <option value="">Nein</option>
                    <option value="yes">Ja</option>
                    <option value="only">Nur gelöscht</option>
                </select>
            </div>
            {{--<div class="form-group row">--}}
            {{--<label>Pro Seite</label>--}}
            {{--<select class="form-control" name="per_page">--}}
            {{--<option>10</option>--}}
            {{--<option>25</option>--}}
            {{--<option>50</option>--}}
            {{--<option>100</option>--}}
            {{--<option value="-1">All</option>--}}
            {{--</select>--}}
            {{--</div>--}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">Abbrechen</button>
            <button type="button" class="btn btn-primary btn-sm"
                    id="filterDomainButton">
                Anwenden
            </button>
        </div>
    </form>
@endsection
