@extends('layouts.modal-layout')
@section('content')
    <form action="{{route('delete-domain-process')}}" method="post">
        @csrf
        <div class="modal-body">
            <p>{{ __('admin-domain.domainDeleteConfirmationMessage') }}</p>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">{{ __('admin-domain.no') }}</button>
            <button type="submit" class="btn btn-danger btn-sm">
                {{ __('admin-domain.deleteButton') }}
            </button>
        </div>
    </form>
@endsection
