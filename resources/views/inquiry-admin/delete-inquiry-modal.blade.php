@extends('layouts.modal-layout')
@section('content')
    <form action="{{route('delete-inquiry-process')}}" method="post">
        @csrf
        <div class="modal-body">
            <p>{{ __('admin-inquiry.deleteInquiryConfirmationMessage') }}</p>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm"
                    data-dismiss="modal">{{ __('admin-inquiry.no') }}</button>
            <button type="submit" class="btn btn-danger btn-sm">
                {{ __('admin-inquiry.deleteButton') }}
            </button>
        </div>
    </form>
@endsection
