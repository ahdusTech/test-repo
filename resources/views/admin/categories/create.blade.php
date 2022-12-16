@extends('layouts.admin')

@section('content')

<style>
    input{
  display: none;
}

label{
    cursor: pointer;
}

#imageName{
        color: black;
      }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kategorien hinzuf&#252;gen</h3>
                </div>

<form method="POST" action="{{ route('admin.store.categories') }}" enctype="multipart/form-data">
    @csrf

    <div class="card-body">

        {{-- @include('admin.layouts.session_message') --}}

        <div class="form-group row">
            <div style="width: 100%;display: flex;">
                <label class="col-sm-2 col-form-label" style="width: 20%;"> Aktiv? <code>*</code></label>
                <div class="col-sm-4" style="width: 30%;">
                    <input type="checkbox" style="display: block;" name="status" checked>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label"> Kategorie Name <code>*</code></label>
            <div class="col-sm-4">
                <input required class="form-control @error('name') is-invalid @enderror" name="name"
                       @if(old('name'))
                       value="{{old('name')}}"
                       @elseif(isset($user->name))
                       value="{{$user->name}}"
                       @endif>
                @error('name')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label" style="width: 20%;"> Kategorie-Bild (888 x 666) <code>*</code>
            </label>
            <div class="col-sm-4">
                <label for="inputTag">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Datei ausw&#0228;hlen</i>
                    <input id="inputTag" type="file"/ name="image">
                    <span id="imageName" style="font-weight: 400">No file Chosen</span>
                  </label>
                  <span class="text-danger" id="image-input-error"></span>
                  @error('image')
            <span class="invalid-feedback error" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>

        <script>
            let input = document.getElementById("inputTag");
            let imageName = document.getElementById("imageName")

            input.addEventListener("change", ()=>{
                let inputImage = document.querySelector("input[type=file]").files[0];

                imageName.innerText = inputImage.name;
            })

        </script>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm float-right"> Kategorie erstellen </button>
            <a href="{{ route('admin.categories') }}" class="btn btn-default btn-sm float-right filterButton" style="border-color: #ddd">
                Abbrechen
            </a>
        </div>
    </div>



</form>
        </div>
    </div>
</div>

@endsection
