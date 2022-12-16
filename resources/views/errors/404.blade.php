@extends('errors::minimal')

@section('title', __('Not Found'))

@if ($exception->getMessage())
    @section('message', $exception->getMessage())
@else
    @section('code', '404')
    @section('message', __('Not Found'))
@endif
