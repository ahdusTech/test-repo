@extends('layouts.admin')

@section('content')
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
        <strong>Hoppla!</strong> Es gab einige Probleme mit Ihrer Eingabe.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Unterkategorie hinzuf&#252;gen </h3>
                </div>

    <form method="POST" action="{{ route('admin.update.photos') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category_id }}">
    <input type="hidden" name="id" value="{{ $photo->id }}">

    <div class="card-body">

        <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" @if($photo->status == 'on') checked @endif>
            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Beschreibung <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required class="form-control" name="description" autofocus
                    @if(old('description'))
                       value="{{old('description')}}"
                       @elseif(isset($photo->description))
                       value="{{$photo->description}}"
                       @endif>

                </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Unterkategorie zuweisen <code>*</code></label>
            <div style="width: 30%;">

                <select class="form-control" name="sub_category_id">
                    <option value="">Bitte w&#228;hlen</option>
                    @foreach ($sub_categories as $subcategory)
                    <option value="{{ $subcategory->id }}" @if($photo->sub_category_id == $subcategory->id) selected @endif>{{ $subcategory->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Bild <code>*</code></label>
            <div style="width: 30%;">

                <img src=" {{ asset('/images/photos/originalResized/'.$photo->originalResized) }} "
                style="object-fit: cover;width: 32.255rem;border: 1px solid lightgrey;">

            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> hochgeladenes Datum <code>*</code></label>
            <div style="width: 30%;">

                <p style="font-weight: bold;">
                    {{ $photo->created_at }}
                </p>

            </div>
        </div>

        <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Upload <code>*</code>
            </label>
            <div style="width: 30%;">
                <label for="inputTag1">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Upload</i>
                    <input id="inputTag1" type="file"/ name="image">
                    <span id="imageName1" style="font-weight: 400">Keine Datei ausgewählt</span>
                  </label>
            </div>
        </div>

            </div>
<div class="card-footer" style="text-align: right;">
<a href="{{ route('admin.photos', [$category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
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
