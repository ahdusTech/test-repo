@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if(session('success'))
   <div class="alert alert-success">
      {{ session('success') }}
   </div>
 @endif

    <div class="content">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Fotoverwaltung </h3>

                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group has-search input-group">
                                <span class="fa fa-search form-control-feedback"></span>

                                <select id="yajraSearch" class="form-control">
                                        @if ($category_name == '')
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                        @else
                                        <option value="{{ $category_name }}">{{ $category_name }}</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                        @endif

                                     </select>

                                <span class="input-group-append">
                                    <button type="submit" onclick="updatePhoto()" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                </span>



                            </div>
                        </div>

                            <div class="float-right col-md-8" style="text-align: right">
                                <a href="javascript::void()" onclick="updatePhoto(this.id,'Foto hochladen');"  id="submit-button"  class="btn btn-primary" style="font-size: 13px;">
                                    Foto hochladen
                                </a>
                            </div>
                    </div>

            <table class="table table-striped table-bordered data_table_yajra"
            data-url="{{route('admin.getAllPhotos')}}"
                    data-length="{{$page_length}}"
                    data-custom-order="5"
                    data-table-show="1"
                    data-custom-sort-type="asc"
                    data-table-name="logo-table"
            style="width:100%;    font-size: 13px !important;">
         <thead>
         <tr>

            @foreach($columns as $column_key=>$column_val)

                            <th data-column="{{$column_key}}"
                            @if(isset($column_val['type']))
                            data-custom-type="{{$column_val['type']}}"
                            @endif
                            @if($column_val['name'] == '#')
                            style="text-align: right !important; padding-right: 6px; width:25px;"
                            @endif
                            @if($column_val['name'] == 'Foto-ID')
                            style="width: 45px;"
                            @endif
                            @if($column_val['name'] == 'Foto')
                            style="width: 153px;text-align: center;"
                            @endif
                            @if($column_val['name'] == 'Aktiv?')
                            style="text-align: center !important; width:35px; padding-left: 12px !important;"
                            @endif
                            @if($column_val['name'] == 'Version Aktiv')
                            style="width:140px;"
                            @endif
                            {{--  @if($column_val['name'] == 'Unterkategorie')
                            style="width: 140px;"
                            @endif  --}}
                            @if($column_val['name'] == 'Hochgeladenes Datum')
                            style="width:151px;"
                            @endif
                            @if($column_val['name'] == 'Aktion')
                            style="width:44px;"
                            @endif
                            @if(!$column_val['sort']) class="no-sort" @endif
                            data-sort="{{$column_val['sort']}}">{!! $column_val['name'] !!}
                        </th>
            @endforeach
         </tr>
         </thead>
         <tbody>
         </tbody>

        </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updatePhoto(id, newText){
        var category_name       = $('select option:selected').val();
        var sendCatName         = document.getElementById(id);
        sendCatName.value       = newText;
        sendCatName.innerHTML   = newText;

        var url = '{{ route("admin.getCatName.photos", ":name") }}';
        url = url.replace(':name', category_name);
        {{--  alert(url);  --}}

      $.ajax({
                type:"get",
                url: url,
                dataType: 'json',
                success:function(response){
                    var category_name = response.name;

                    var url2 = "{{ url('admin/create/photos') }}"+ '/' +category_name;
                    window.location.href= url2;
                  }
              });
          }


</script>
@endsection
