@extends('layouts.admin')

@section('content')
{{--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  --}}
<style>
    input{
  display: none;
}

label{
    cursor: pointer;
}

#imageName1{
        color: black;
      }
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if (count($errors) > 0)
      <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            {{ $error }}
          @endforeach
      </div>
      @endif

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Unterkategorie hinzuf&#252;gen </h3>
                </div>

    <form method="POST" action="{{ route('admin.store.version.photos') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="photo_id" value="{{ $photo_id }}">
    <input type="hidden" name="counter" value="{{ $counter }}">
    <input type="hidden" name="category_name" value="{{ $category_name }}">
    <input type="hidden" name="color" value="{{ $color }}">
    <div class="card-body">

        <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" checked>
            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Beschreibung <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required class="form-control" name="description" autofocus>

                </div>
        </div>

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Unterkategorie zuweisen <code>*</code></label>
            <div style="width: 30%;">

                {!! Form::select('sub_category_id', $sub_categories, null, ['class' => 'form-control']) !!}

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Farbton <code>*</code></label>
            <div style="width: 30%;">
                <select name="color" class="form-control" required>
                    <option value="Farbe">Farbe</option>
                    <option value="Schwarz/Weiß">Schwarz/Weiß</option>
                    <option value="Sepia">Sepia</option>
                </select>
            </div>
        </div>  --}}


        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Upload <code>*</code>
            </label>
            <div style="width: 30%;">
                <label for="inputTag1">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Upload</i>
                    <input id="inputTag1" type="file"/ name="image">
                    <span id="imageName1" style="font-weight: 400">Keine Datei ausgew&#xe4;hlt</span>
                  </label>
            </div>
        </div>

            </div>
<div class="card-footer" style="text-align: right;">
<a href="{{ route('admin.edit.photos', ['photo_id' => $photo_id, 'category_name' => $category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>
    <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Unterkategorie erstellen </button>

</div>

</form>
        </div>
    </div>
</div>



<script>
    let input = document.getElementById("inputTag1");
    let imageName = document.getElementById("imageName1")

    input.addEventListener("change", ()=>{
        let inputImage1 = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage1.name;
    })

</script>

@endsection
