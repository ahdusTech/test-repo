@extends('layouts.admin')

@section('content')

{{--  <style>
    input{
  display: none;
}

label{
    cursor: pointer;
}

#imageName{
        color:green;
      }

#imageName2{
        color: black;
}
</style>  --}}

<style type="text/css">
    #page-loader {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10000;
    display: none;
    text-align: center;
    width: 100%;
    padding-top: 25px;
    background-color: rgba(255, 255, 255, 0.7);
    /*background-color: rgba(255, 255, 255, 0.7); */
}
</style>
 <div id="page-loader">
            <h3> Loading page... Please wait</h3>
            <img src="http://css-tricks.com/examples/PageLoadLightBox/loader.gif" alt="loader">
            <p><small> <b> You will be redirected after a while. Thank You</b> </small></p>
</div>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if (count($errors) > 0)
    <div class = "alert alert-danger">
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
                    <h3 class="card-title"> Unterkategorie hinzufügen </h3>
                </div>

{{--  <form method="POST" action="{{ route('admin.store.subcategories') }}" id="upload-image-form" enctype="multipart/form-data">  --}}
    <form method="POST" action="{{ route('admin.store.subcategories') }}" enctype="multipart/form-data">
    @csrf

    <div class="card-body">

        <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" checked>
            </div>
        </div>
        <div>
            <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Unterkategorie-Name <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required="" class="form-control" name="name" autofocus>

                </div>
            </div>

            {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="image" class="col-form-label" style="width: 20%;"> Select Image <code>*</code>
                </label>
                <div style="width: 30%;">  --}}

                    {{--  <label for="inputTag">
                        <i class="btn btn-primary" style="font-style: inherit;">choose Image</i>
                        <input id="inputTag" type="file"/ name="image">
                        <span id="imageName" style="font-weight: 400">No file Chosen</span>

                      </label>

                      <span class="text-danger" id="image-input-error"></span>  --}}
                      {{--  <input type="file" name="image" required>
                </div>

            </div>  --}}

            {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="watermark" class="col-form-label" style="width: 20%;"> Select Water Mark <code>*</code>
                </label>
                <div style="width: 30%;">

                    <label for="inputTag2">
                        <i class="fa fa-2x fa-camera" style="color: green;"></i>
                        <input id="inputTag2" type="file"/ name="watermark">
                        <span id="imageName2"></span>

                      </label>

                      <span class="text-danger" id="image-input-error2"></span>
                </div>

            </div>  --}}


            {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="image_title" class="col-form-label" style="width: 20%;"> Image title <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required="" class="form-control" name="image_title">

                </div>
            </div>  --}}

            {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="image_price" class="col-form-label" style="width: 20%;"> Image Price <code>*</code></label>
                <div style="width: 30%;">
                    <input type="number" required="" class="form-control" name="image_price">

                </div>
            </div>  --}}

            <input type="hidden" name="category_id" value="{{ $category_id }}">

            {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="category_id" class="col-form-label" style="width: 20%;"> Select Parent Category <code>*</code></label>
                <div style="width: 30%;">

                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}

                </div>
            </div>  --}}

        </div>
            </div>
<div class="card-footer" style="text-align: right;">
<a href="{{ route('admin.subcategories', [$category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>
    <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Unterkategorie erstellen </button>

</div>

</form>
        </div>
    </div>
</div>

{{--  <script>
    let input = document.getElementById("inputTag");
    let imageName = document.getElementById("imageName")

    input.addEventListener("change", ()=>{
        let inputImage = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage.name;
    })

    //logo
    let input2 = document.getElementById("inputTag2");
    let imageName2 = document.getElementById("imageName2")

    input2.addEventListener("change", ()=>{
        let inputImage2 = document.querySelector("#inputTag2").files[0];

        imageName2.innerText = inputImage2.name;
    })
</script>  --}}


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $('#upload-image-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $('#image-input-error').text('');
       $('#image-input-error2').text('');

       $.ajax({
          type:'POST',
          url: "{{ route('admin.store.subcategories') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               this.reset();
            //    alert('Image has been uploaded successfully');

            swal({
                title: "Congratualtions!",
                text: "Image has been uploaded successfully",
                icon: "success",
                buttons: "OK",
                })
                .then((willDelete) => {
                if (willDelete) {

                    window.location.href = "{{ route('admin.subcategories') }}";
                }
                });

             }
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
                $('#image-input-error2').text(response.responseJSON.errors.file);
           }
       });
  });

</script>

<script type="text/javascript">
    $( document ).ajaxStart(function() {
     document.getElementById("page-loader").style.display = 'block';

    });

$( document ).ajaxStop(function() {
     document.getElementById("page-loader").style.display = 'none';

    });
</script>

@endsection
