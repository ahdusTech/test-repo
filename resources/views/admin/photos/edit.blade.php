@extends('layouts.admin')

@section('content')


<style>
    input{
  {{--  display: none;  --}}
}

label{
    cursor: pointer;
}

#imageName1{
        color: black;
      }


.version_status {
    {{--  display: none;  --}}
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
                {{--  <div class="card-header">
                    <h3 class="card-title"> Foto bearbeiten </h3>
                </div>  --}}

    <form method="POST" action="{{ route('admin.update.photos') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category_id }}">
    <input type="hidden" name="id" value="{{ $photo->id }}">

    <div>
        <span class="version_status">

        </span>
    </div>
    <div class="card-body">

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Aktiv? <code>*</code></label>
            <div style="width: 30%;">
                <input type="checkbox" style="display: block;" name="status" @if($photo->status == 'on') checked @endif>
            </div>
        </div>  --}}

         <div class="form-group" style="width: 100%;display: flex;">
            <label style="width: 20%;"> Fotonumber: </label>
            <div style="width: 30%;">
                <span>
                    {{ $photo->id }}
                </span>
            </div>
        </div>

        {{--  <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Beschreibung <code>*</code></label>
                <div style="width: 30%;">
                    <input type="text" required class="form-control" name="description" autofocus
                    @if(old('description'))
                       value="{{old('description')}}"
                       @elseif(isset($photo->description))
                       value="{{$photo->description}}"
                       @endif>

                </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="category_id" class="col-form-label" style="width: 20%;"> Unterkategorie zuweisen <code>*</code></label>
            <div style="width: 30%;">

                <select class="form-control" name="sub_category_id">
                    <option value="">Bitte w&#228;hlen</option>
                    @foreach ($sub_categories as $subcategory)
                    <option value="{{ $subcategory->id }}" @if($photo->sub_category_id == $subcategory->id) selected @endif>{{ $subcategory->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Bild <code>*</code></label>
            <div style="width: 30%;">

                <img src=" {{ asset('/images/photos/originalResized/'.$photo->originalResized) }} "
                style="object-fit: cover;width: 32.255rem;border: 1px solid lightgrey;">

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> hochgeladenes Datum <code>*</code></label>
            <div style="width: 30%;">

                <p style="font-weight: bold;">
                    {{ $photo->created_at }}
                </p>

            </div>
        </div>  --}}

        {{--  <div class="form-group" style="width: 100%;display: flex;">
            <label for="image" class="col-form-label" style="width: 20%;"> Upload <code>*</code>
            </label>
            <div style="width: 30%;">
                <label for="inputTag1">
                    <i class="btn btn-primary" style="font-style: inherit;font-size: 14px;">Upload</i>
                    <input id="inputTag1" type="file"/ name="image">
                    <span id="imageName1" style="font-weight: 400">Keine Datei ausgewählt</span>
                  </label>
            </div>
        </div>  --}}

        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="nav-item">
                <a href="#Farbe" aria-controls="Farbe" role="tab" data-toggle="tab" class="nav-link active">
                    Farbe ()
                </a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#color" aria-controls="color" role="tab" data-toggle="tab" class="nav-link">
                Schwarz/Weiß ()
                </a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#Sepia" aria-controls="Sepia" role="tab" data-toggle="tab" class="nav-link">
                    Sepia ()
                </a>
            </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content mt-3" id="nav-tabContent" style="width: 50%;">
            <div role="tabpanel" class="tab-pane fade show active" id="Farbe">

                <div style="width: 100%;text-align: right;">
                <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color' => 'C']) }}" class="btn btn-primary btn-sm" style="margin-top: -102px;"> Neue Version </a>
                </div>

             <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 1: </label>
                <div style="display: flex">
                    <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                    <input type="text" required class="form-control" name="description" readonly>

                </div>
             </div>
             <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 2: </label>
                <div style="display: flex">
                    <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                    <input type="text" required class="form-control" name="description" readonly>

                </div>
             </div>
             <div class="form-group" style="width: 100%;display: flex;">
                <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 3: </label>
                <div style="display: flex">
                    <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                    <input type="text" required class="form-control" name="description" readonly>

                </div>
             </div>

             <div style="width: 100%;display: flex;">
             <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
            <thead>
                <tr>
                    <th style="text-align: right !important; padding-right: 6px; width:35px;">#</th>
                    <th style="text-align: right !important; padding-right: 6px; width:60px;">Foto Version</th>
                    <th style="width: 153px;text-align: center;">Foto</th>
                    <th style="width:151px;">hinzugefügt</th>
                    <th style="width:44px;">Aktiv</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($color_version_photos as $key => $color_version_photo)
                <tr>
                    <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                    <td style="text-align: right !important; padding-right: 6px;">{{ $color_version_photo->counter }}</td>
                    <td style="text-align: center;">
                        <img src="{{ asset('/images/version_photos/thumbnail/'.$color_version_photo->small_thumbnail) }}" style="width: 100px;height: 100px;object-fit: cover;">
                    </td>
                    <td>{{ $color_version_photo->created_at }}</td>
                    <td>
                        <input type="checkbox" {{ $color_version_photo->status == 'on' ? 'checked' : '' }}
                        name="id" onchange="updateStatus({{ $color_version_photo->id }}, this)">
                        <a href="{{ route('admin.delete.version', ['id' => $color_version_photo->id, 'photo_id' => $photo->id, 'category_name' => $category_name, 'color' => $color_version_photo->color]) }}" style="color: black">
                            <i class="fa fa-trash"> </i>
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="color">
                <div style="width: 100%;text-align: right;">
                    <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color' => 'B']) }}" type="button" class="btn btn-primary btn-sm" style="margin-top: -102px;"> Neue Version </a>
                    </div>
                <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 1: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>
                 <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 2: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>
                 <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 3: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>

                 <div style="width: 100%;display: flex;">
                 <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
                <thead>
                    <tr>
                        <th style="text-align: right !important; padding-right: 6px; width:35px;">#</th>
                        <th style="text-align: right !important; padding-right: 6px; width:60px;">Foto Version</th>
                        <th style="width: 153px;text-align: center;">Foto</th>
                        <th style="width:151px;">hinzugefügt</th>
                        <th style="width:44px;">Aktiv</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($black_white_version_photos as $key => $black_white_version_photo)
                    <tr>
                        <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                        <td style="text-align: right !important; padding-right: 6px;">{{ $black_white_version_photo->counter }}</td>
                        <td style="text-align: center;">
                        <img src="{{ asset('/images/version_photos/thumbnail/'.$black_white_version_photo->small_thumbnail) }}" style="width: 100px;height: 100px;object-fit: cover;">
                        </td>
                        <td>{{ $black_white_version_photo->created_at }}</td>
                        <td>
                            <input type="checkbox" {{ $black_white_version_photo->status == 'on' ? 'checked' : '' }}
                        name="id" onchange="updateStatus({{ $black_white_version_photo->id }}, this)">
                            <a href="{{ route('admin.delete.version', ['id' => $black_white_version_photo->id, 'photo_id' => $photo->id, 'category_name' => $category_name , 'color' => $black_white_version_photo->color]) }}" style="color: black">
                                <i class="fa fa-trash"> </i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>



            </div>
            <div role="tabpanel" class="tab-pane" id="Sepia">
                <div style="width: 100%;text-align: right;">
                    <a href="{{ route('admin.create.versions', ['photo_id' => $photo->id, 'counter' => $photo->counter, 'color' => 'S']) }}" type="button" class="btn btn-primary btn-sm" style="margin-top: -102px;"> Neue Version </a>
                    </div>
                <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 1: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>
                 <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 2: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>
                 <div class="form-group" style="width: 100%;display: flex;">
                    <label for="name" class="col-form-label" style="width: 20%;"> Kategorie 3: </label>
                    <div style="display: flex">
                        <input type="text" required class="form-control" name="description" readonly>&nbsp; &nbsp;
                        <input type="text" required class="form-control" name="description" readonly>

                    </div>
                 </div>

                 <div style="width: 100%;display: flex;">
                 <table class="table table-striped table-bordered data_table_yajra" style="width:100%;    font-size: 13px !important;">
                <thead>
                    <tr>
                        <th style="text-align: right !important; padding-right: 6px; width:35px;">#</th>
                        <th style="text-align: right !important; padding-right: 6px; width:60px;">Foto Version</th>
                        <th style="width: 153px;text-align: center;">Foto</th>
                        <th style="width:151px;">hinzugefügt</th>
                        <th style="width:44px;">Aktiv</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sepia_version_photos as $key => $sepia_version_photo)
                    <tr>
                        <td style="text-align: right !important; padding-right: 6px;">{{ ++$key }}</td>
                        <td style="text-align: right !important; padding-right: 6px;">{{ $sepia_version_photo->counter }}</td>
                        <td style="text-align: center;">
                            <img src="{{ asset('/images/version_photos/thumbnail/'.$sepia_version_photo->small_thumbnail) }}" style="width: 100px;height: 100px;object-fit: cover;">
                        </td>
                        <td>{{ $sepia_version_photo->created_at }}</td>
                        <td>
                            <input type="checkbox" {{ $sepia_version_photo->status == 'on' ? 'checked' : '' }}
                        name="id" onchange="updateStatus({{ $sepia_version_photo->id }}, this)">
                            <a href="{{ route('admin.delete.version', ['id' => $sepia_version_photo->id , 'photo_id' => $photo->id, 'category_name' => $category_name, 'color' => $sepia_version_photo->color]) }}" style="color: black">
                                <i class="fa fa-trash"> </i>
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>


            </div>
        </div>

            </div>
<div class="card-footer" style="text-align: right;">
<a href="{{ route('admin.photos', [$category_name]) }}" class="btn btn-default btn-sm filterButton" style="border-color: #ddd">
    Abbrechen
</a>
    {{--  <button type="submit" class="btn btn-primary btn-sm filterButton" style="font-size: 13px;"> Unterkategorie erstellen </button>  --}}
    <a href="#" class="btn btn-primary btn-sm" style="font-size: 13px;"> Unterkategorie erstellen </a>

</div>

</form>
        </div>
    </div>
</div>

{{--  <script>
    let input = document.getElementById("inputTag1");
    let imageName = document.getElementById("imageName1")

    input.addEventListener("change", ()=>{
        let inputImage1 = document.querySelector("input[type=file]").files[0];

        imageName.innerText = inputImage1.name;
    })

</script>  --}}

		<script>
    		$(document).ready(function() {
        		// Activate the history tabs.
                $('a[data-toggle="tab"]').historyTabs();
    		});
		</script>


<script>
    +function ($) {
        'use strict';
        $.fn.historyTabs = function() {
            var that = this;
            window.addEventListener('popstate', function(event) {
                if (event.state) {
                    $(that).filter('[href="' + event.state.url + '"]').tab('show');
                }
            });
            return this.each(function(index, element) {
                $(element).on('show.bs.tab', function() {
                    var stateObject = {'url' : $(this).attr('href')};

                    if (window.location.hash && stateObject.url !== window.location.hash) {
                        window.history.pushState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                    } else {
                        window.history.replaceState(stateObject, document.title, window.location.pathname + $(this).attr('href'));
                    }
                });
                if (!window.location.hash && $(element).is('.active')) {
                    // Shows the first element if there are no query parameters.
                    $(element).tab('show');
                } else if ($(this).attr('href') === window.location.hash) {
                    $(element).tab('show');
                }
            });
        };
    }(jQuery);
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function updateStatus(id, checkbox) {
        $.ajax({
            url: "{{ route('admin.update.status') }}",
            type: "POST",
            data: {
                id: id,
                status: checkbox.checked ? 'on' : 'off'
            },
            success: function(response) {
                if (response.status == 'Active') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }
    </script>


@endsection
