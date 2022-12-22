@extends('layouts.admin')
@section('content')

<style>
.table td {
    height: 28px !important;
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
                    <h3 class="card-title">Kategorien</h3>
                    <div class="float-right">
                        <a href="{{ route('admin.create.categories') }}" class="btn btn-primary" style="font-size: 13px;">
                            Kategorie hinzuf&#252;gen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-search input-group">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control"
                                   @if(isset($_REQUEST['search']) && !empty(trim($_REQUEST['search'])))
                                   value="{{trim($_REQUEST['search'])}}"
                                   @endif id="yajraSearch"
                                   placeholder="Suche">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary yajraBtnSearch">Suchen</button>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label data-href="{{route('get-delete-logo-modal-cat')}}"
                               data-id=""
                               data-name="get-multi-option-modal" style="cursor: pointer"
                               class="btn btn-default float-right invisible filterButton OpenModal">
                            <i class="fa fa-trash"></i></label>
                    </div>
                </div>
                <table class="table table-striped table-bordered data_table_yajra"
                data-url="{{route('admin.getAllCatJson')}}"
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
                            style="text-align: right !important; padding-right: 6px; width:20px;"
                            @endif
                            @if($column_val['name'] == 'Aktiv?')
                            style="text-align: center !important; width:50px; padding-left: 12px !important;"
                            @endif
                            @if($column_val['name'] == 'Kat-ID')
                            style="text-align: right; padding-right: 12px; width:52px;"
                            @endif
                            @if($column_val['name'] == 'Aktion')
                            style="width:50px;"
                            @endif
                            @if($column_val['name'] == 'Sortierung')
                            style="width:70px;"
                            @endif
                            @if($column_val['name'] == 'Bild')
                            style="text-align: center !important; width:120px; padding-left: 12px !important;"
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

        {{--  <script type="text/javascript">
            $(function () {

              var table = $('.data_table_yajra').DataTable({
                  processing: true,
                  serverSide: true,
                  bInfo: true,
                  paging: false,
                  bPaginate: false,
                  ajax: "{{ route('admin.getAllCatJson') }}",
                  columns: [
                    {data: 'id', name: 'id'},
                    {data: 'status', name: 'status'},
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'sort',name: 'sort'},
                    {data: 'action', name: 'action'},

                  ]
              });

            });
          </script>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
