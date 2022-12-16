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
                    <h3 class="card-title">Kategorie hinzufügen/ändern</h3>
                </div>

<form method="post" action="{{route('admin.update.categories',  [$category->id]) }} " enctype="multipart/form-data">
    @csrf

    <div class="card-body">

        <input type="hidden" value="{{ $category->id }}" name="id" >
        <div class="form-group row">
            <div style="width: 100%;display: flex;">
                <label class="col-sm-2 col-form-label" style="width: 20%;"> Aktiv? <code>*</code></label>
                <div class="col-sm-4" style="width: 30%;">
                    <input type="checkbox" style="display: block;" name="status" @if($category->status == 'active') checked @endif>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label"> Kategorie-Name <code>*</code></label>
            <div class="col-sm-4">
                <input required class="form-control @error('name') is-invalid @enderror" name="name"
                       @if(old('name'))
                       value="{{old('name')}}"
                       @elseif(isset($category->name))
                       value="{{$category->name}}"
                       @endif>
                @error('name')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <input type="hidden" name="sort" value="{{ $category->sort }}">

        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label"> Bild <code>*</code></label>
            <div class="col-sm-4">

                <img src=" {{ asset('/storage/categories/'.$category->image) }} "
                style="object-fit: cover;width: 32.255rem;border: 1px solid lightgrey;padding: 1%;">

            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label" style="width: 20%;"> Kategorie-Bild (888 x 666)  <code>*</code>
            </label>
            <div class="col-sm-4">
                <label for="inputTag">
                    <i class="btn btn-primary" style="font-style: inherit;">Datei auswählen</i>
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
        <button type="submit" class="btn btn-primary btn-sm float-right"> Update </button>
      <a href="{{ route('admin.categories') }}" class="btn btn-default btn-sm float-right filterButton" style="border-color: #ddd">
        Abbrechen
      </a>


    </div>
</form>

            </div>
        </div>
    </div>
</div>

@endsection
