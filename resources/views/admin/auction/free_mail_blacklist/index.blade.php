@extends('layouts.admin')

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
                        <h3 class="card-title">
                            Freemail Blacklist
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                            <form method="POST" action="{{ route('admin.blacklist_update') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Freemail-Provider</label>
                                    <div class="col-sm-4">
                                        <textarea name="black_list" class="form-control" id="black_list"  rows="18">{{$black_list}} </textarea>
                                        @error('black_list')
                                            <span class="invalid-feedback error" role="alert">
                                                 <strong>{{ $message }}</strong>

                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm float-right"> Speichern </button>
                                    <a href="{{route('dashboard')}}"
                                       class="btn btn-default btn-sm float-right filterButton" style="border-color: #ddd">
                                        Abbrechen
                                    </a>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
