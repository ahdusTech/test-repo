@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success">
        Unterkategorie hinzugef端gt
    </div>
    @endif
    @if(Session::has('UpdateSuccess'))
        <div class="alert alert-success">
            Unterkategorie erfolgreich aktualisiert
        </div>
    @endif
    {{--  <?php $category_name = Session::get('category_name'); ?>  --}}

    <div class="content">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Unterkategorien </h3>
                    {{--  <div class="float-right">
                        <a href="{{ route('admin.create.subcategories') }}" class="btn btn-primary" style="font-size: 13px;">
                            Unterkategorie hinzuf&#252;gen
                        </a>
                    </div>  --}}
                </div>
                <div class="card-body">

                    <div class="row">
                     {{-- @include('admin.layouts.session_message') --}}
                        <div class="col-md-4">
                            <div class="form-group has-search input-group">
                                <span class="fa fa-search form-control-feedback"></span>

                                {{--  <input type="text" class="form-control"
                                    @if(isset($_REQUEST['search']) && !empty(trim($_REQUEST['search'])))
                                    value="{{trim($_REQUEST['search'])}}"
                                    @endif id="yajraSearch"
                                    placeholder="Suche">

                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                </span>  --}}

                                {{--  <select id="yajraSearch" class="form-control" onchange="mainInfo(this.value)">  --}}
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
                                    <button type="submit" onclick="updatetransactions()" class="btn btn-primary yajraBtnSearch">Suchen</button>
                                </span>



                            </div>
                        </div>

                            <div class="float-right col-md-8" style="text-align: right">
                                <a href="javascript::void()" onclick="updatetransactions(this.id,'Unterkategorie hinzuf&#252;gen');"  id="submit-button"  class="btn btn-primary" style="font-size: 13px;">
                                Unterkategorie hinzuf&#252;gen
                                </a>
                            </div>


                        <script>
                            function mainInfo(id) {
                                var csrfToken = $('meta[name="csrf-token"]').attr('content')
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                });
                                {{--  console.log(id);  --}}

                                $.ajax({
                                    type: "GET",
                                    url: "{{route('admin.getAllSubCatJson')}}",
                                    data: "value=" + id,
                                    success: function(result) {
                                        console.log('sucess');
                                    }
                                });
                            };
                        </script>

                    </div>

            <table class="table table-striped table-bordered data_table_yajra"
            data-url="{{route('admin.getAllSubCatJson')}}"
                    data-length="{{$page_length}}"
                    data-custom-order="5"
                    data-table-show="1"
                    data-custom-sort-type="asc"
                    data-table-name="logo-table"
            style="width:100%">
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
                            @if($column_val['name'] == 'Aktiv?')
                            style="text-align: center !important; width:50px; padding-left: 12px !important;"
                            @endif
                            @if($column_val['name'] == 'Sub-ID')
                            style="text-align: right; padding-right: 12px; width:52px;"
                            @endif
                            @if($column_val['name'] == 'Sortierung')
                            style="width:70px;"
                            @endif
                            @if($column_val['name'] == 'Kategorie')
                            style="width:450px;"
                            @endif
                            @if($column_val['name'] == 'Aktion')
                            style="width:150px;"
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

    function updatetransactions(id, newText){
        var category_name       = $('select option:selected').val();
        var sendCatName         = document.getElementById(id);
        sendCatName.value       = newText;
        sendCatName.innerHTML   = newText;

        var url = '{{ route("admin.getCatName.subcategories", ":name") }}';
        url = url.replace(':name', category_name);
        {{--  alert(url);  --}}

      $.ajax({
                type:"get",
                url: url,
                cache: false,
                dataType: 'json',
                success:function(response){
                    var category_name = response.name;
                    {{--  alert(category_name);  --}}

                    var url2 = "{{ url('admin/create/sub-categories') }}"+ '/' +category_name;
                    {{--  console.log(encoded_url);  --}}
                    {{--  alert(encoded_url);  --}}

                    window.location.href= url2;
                  }
              });
          }


</script>

@endsection
