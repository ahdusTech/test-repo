@extends('layouts.modal-layout')
@section('content')
    <form action="{{route('delete-not-found-domain-process')}}" method="post">
        @csrf
        <div class="modal-body">
            <p>Sind Sie sicher, dass Sie alle fehlgeleiteten Domains löschen möchte ?</p>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">Nein</button>
            <button type="submit" class="btn btn-danger btn-sm">
                Löschen
            </button>
        </div>
    </form>
@endsection
