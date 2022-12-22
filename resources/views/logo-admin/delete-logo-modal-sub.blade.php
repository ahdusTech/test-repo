@extends('layouts.modal-layout-sub')
@section('content')
    <form action="{{route('delete-logo-process-sub')}}" method="post">
        @csrf
        <div class="modal-body">
            <p>Möchten Sie die Unterkategorie {{ $name }} wirklich löschen?</p>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">{{ __('admin-logo.no') }}</button>
            <button type="submit" class="btn btn-danger btn-sm">
                {{ __('admin-logo.deleteButton') }}
            </button>
        </div>
    </form>
@endsection
