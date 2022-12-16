@extends('layouts.web.app')
@section('content')

    <style>
        a.active{
    color: #048ba8;

    }

    .AllCategories {
        color: black;
        font-size: 16px;
        display: block;
        margin-top: 7px;

    }

    .ActiveGreenColor {
        font-size: 16px;
        display: block;
        margin-top: 7px;

    }
li {
    list-style: none;
}
ul {
    padding: 0;
}

.img__wrap {
    position: relative;
  }

  .img__description {
    position: absolute;
    bottom: 0px;
    left: 1px;
    right: 1px;
    color: #fff;
    visibility: hidden;
    opacity: 0;
    background: linear-gradient(rgba(183, 135, 152, -107.849), rgb(76, 76, 76) 127%);


    /* transition effect. not necessary */
    transition: opacity .2s, visibility .2s;
  }
  .img__wrap:hover .img__description {
    visibility: visible;
    opacity: 1;
    height:auto;
  }

  .col-lg-4 {
    padding-right: 9px;
}

.zoom {
    transition: transform .2s; /* Animation */
  }

  .zoom:hover {
    transform: scale(1.02);
  }

  .pagination {
    display: inline-block;
    padding-left: 0;
    margin: 0px 10px 10px 10px;
    border-radius: 4px;
    font-family: 'monseratlight';
}

.sub-menus>li>a.active {
    text-decoration: underline;
}

@media (min-width: 1322px) {
    .col-md-2 {
        width: 13%;
    }
}


@media (min-width: 1322px) {
    .col-md-10 {
        width: 87%;
    }
}
@media (max-width: 1400px) {
    .col-md-2 {
        width: 16.666667%;
    }
}
@media (max-width: 1400px) {
    .col-md-10 {
        width: 83.333333%;
    }
}


.sub-menus>li>a {
    font-family: 'monseratlight';
}
        </style>


        <script>
            $(function() {
                 $('#mosaic').Mosaic({
                     innerGap:10,
                     maxRowHeight: 300,
                     maxRowHeightPolicy: 'tail'
                 });

            });
         </script>

        {{--  <div class="row" style="    padding-left: 35px;">
             <div class="col-md-12" style="padding: 0px;">
    <nav aria-label="breadcrumb" >
  <ol class="breadcrumb" style="border-bottom: 1px solid lightgrey;font-size: 16px;padding: 14px 0px 15px 0px;">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}" style="color: black;">Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
  </ol>
</nav>
             </div>
        </div>  --}}

        <div class="row" style="min-height: calc(100vh - 40px);margin: auto;position: relative">
            <div class="col-md-2" style="border-right: 1px solid lightgrey;padding-left: 19px;padding-top: 1%;background: white">
                <ul class="sub-menus" style="background: none">

                        <li>
                            <a class="nav-link {{ (request()->is('collections/'.$categoryId.'/'.$categoryName)) ? 'active' : '' }}"
                            href="{{ route('collections',['categoryId' =>$categoryId,'categoryName' => $categoryName]) }}"
                            class="ActiveGreenColor" style="font-size: 14px;padding: 0px 0px 0px 9px;font-family: 'monseratlight';">
                                All
                            </a>
                        </li>

                        @foreach ($subcategories as $subcategory )
                        @if ($subcategory->status == 'active')

                        <li>
                            <a class="nav-link {{ (request()->is('collections-photo/cat-id/'.$categoryId.'/cat/'.$categoryName.'/sub-id/'.$subcategory->id.'/sub/'.$subcategory->name)) ? 'active' : '' }}"
                            href="{{ route('photo.collections',['categoryId' =>$categoryId,'categoryName' => $categoryName,'subcategoryId' => $subcategory->id,'subcategoryName' => $subcategory->name]) }}"
                            style="font-size: 14px;padding: 0px 0px 0px 9px;font-family: 'monseratlight';">
                                {{ $subcategory->name }}
                            </a>
                        </li>
                        @endif
                        @endforeach

                </ul>
        </div>
       <style>
                .filterData {
    margin-right: 7px;
              }

            </style>
        <div class="col-md-10" style="margin-bottom: 1%;padding: 0px;background: white;">

            <div class="row" style="background: white;margin: auto;padding: 7px 10px 7px 10px;padding-right: 28px;">
                <div class="filterData" style="text-align: right">
                    <div class="flex justify-end">
                        <span class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-center rounded-l-lg focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white">
                        SORT BY
                    </span>
                        {{--  <label for="states" class="sr-only">Choose a state</label>  --}}
                        <select id="states" class=" border border-gray-300 rounded border-l-2 p-2.5" style="background-color: rgb(253,253,253);">
                            <option selected="">Featured</option>
                            <option value="CA">California</option>
                            <option value="TX">Texas</option>
                            <option value="WH">Washinghton</option>
                            <option value="FL">Florida</option>
                            <option value="VG">Virginia</option>
                            <option value="GE">Georgia</option>
                            <option value="MI">Michigan</option>
                        </select>
                    </div>

{{--
                    <i class="fa fa-angle-down" aria-hidden="true"></i>

                    <a href="#" style=""><i class="fa fa-th-large" aria-hidden="true" style="color: black;"></i></a>
                    <a href="#" style="/* margin-left: 117px; */"><i class="fa fa-list" aria-hidden="true" style="color: black;"></i></a>  --}}

                </div>
            </div>


            <div class="row" style="margin: auto;background: #F7F7F7;border-top: 1px solid gainsboro;">
                <div class="row mt-3 mb-3" style="background: #F7F7F7;margin: auto;padding-right: 26px;padding-left: 25px;">
                    <div class="row" style="margin: auto;padding-right: 0;">


                        <div class="col-md-6" style="font-size: 18px;padding: 0px">
                        {{--  {{ $categoryName }}  --}}
                        {{--  @if ($latestPhotos->hasPages())  --}}
                        <ul class="text-2xl bg-inherit mt-2.5"
                        style="color: #555555 !important;font-family: 'monseratlight';font-size: 12px;">
                            {{-- Previous Page Link --}}
                            {{--  @if ($latestPhotos->onFirstPage())
                                <li class="disabled"><span>{{ __('Prev') }}</span></li>
                            @else
                                <li><a href="{{ $latestPhotos->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>
                            @endif  --}}



                        @if($latestPhotos->firstItem() == '')

                         {{ 0 . " - " . $latestPhotos->lastItem() ."  of  " . $latestPhotos->total() . " Photos "}}

                        @else
                           {{ $latestPhotos->firstItem() . " - " . $latestPhotos->lastItem() ."  of  " . $latestPhotos->total() . " Photos "}}

                        @endif

                    {{--  {{ $latestPhotos->firstItem() . " - " . $latestPhotos->lastItem() ."  of  " . $latestPhotos->total() . " Photos "}}  --}}


                            {{-- Next Page Link --}}
                            {{--  @if ($latestPhotos->hasMorePages())
                                <li><a href="{{ $latestPhotos->nextPageUrl() }}" rel="next">{{ __('Next') }}</a></li>
                            @else
                                <li class="disabled"><span>{{ __('Next') }}</span></li>
                            @endif  --}}
                        </ul>
                    {{--  @endif  --}}

                    <style>
                        .nextPage {
                        background-color: #F7F7F7 !important;
                        border: none !important;
                        color: black !important;
                        }

                        .page-item.active .page-link {
                            background-color: #F7F7F7 !important;
                            border: 1px solid #555555 !important;;
                            border-radius: 5px;
                            color: black;

                        }
                        .nextPageNumber {
                            background-color: #F7F7F7 !important;
                            border: none !important;
                            color: black !important;
                            font-size: 16px;
                        }

                        .page-link:focus {
                            box-shadow: none !important;
                        }


                    </style>
                        </div>
                        <div class="col-md-6" style="text-align: right;padding-right: 0px;">
                        {{--  {{ $latestPhotos->links() }}  --}}
                        <ul class="pagination">
                            @if ($latestPhotos->onFirstPage())
                                <li class="disabled"></li>
                            @else
                                 <li>
                                    <a href="{{ $latestPhotos->previousPageUrl() }}" rel="prev" class="nextPage text-xl"
                                    style="color: #555555 !important;font-size: 12px;font-family: 'monseratlight';padding: 7px 10px 10px 10px;">
                                    Prev
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $latestPhotos->previousPageUrl() }}" rel="prev" class="nextPage text-xl"
                                    style="color: #555555 !important;font-size: 12px;font-family: 'monseratlight';padding: 7px 10px 10px 10px;">
                                    {{ $latestPhotos->currentPage() - 1 }}
                                    </a>
                                </li>
                             @endif

                              <li class="page-item active" aria-current="page">
                                <span class="page-link text-xl" style="padding: 1.5px 2px 1px 8px;color: #555555 !important;margin-top: 4px;font-weight: 600;">
                                {{ $latestPhotos->currentPage() }}&nbsp;&nbsp;
                                </span>
                            </li>

                            @if (!$latestPhotos->hasMorePages())
                                <li class="disabled"></li>
                            @else
                            <li class="page-item">
                                <a class="page-link nextPageNumber text-xl"
                                style="padding-right: 1px;color: #555555 !important;font-size: 12px;font-size: 12px;font-family: 'monseratlight';" href="{{ $latestPhotos->nextPageUrl() }}">
                                    {{ $latestPhotos->currentPage() + 1 }}&nbsp;&nbsp;
                                </a>
                            </li>
                            @endif

                           {{-- Next Page Link --}}
                             @if ($latestPhotos->hasMorePages())
                                 <li>
                                    <a href="{{ $latestPhotos->nextPageUrl() }}" rel="next" class="nextPage text-xl" style="color: #555555 !important;padding-right: 9px;font-size: 12px;">
                                        Next
                                    </a>
                                </li>
                             @else
                                  <li class="disabled"><span class="nextPage text-xl" style="color: #555555 !important;padding-right: 9px;font-size: 12px;">Next</span></li>
                              @endif
                          </ul>

                        </div>
                    </div>
                    <style>
                        .jQueryMosaic > .item:hover > .saveText {
                            opacity: 1;
                        }
                        .jQueryMosaic > .item > .saveText {
                            opacity: 0;
                            position: absolute;
                            text-align: right;
                            /*  left: 0px; */
                            right: 11px;
                            top: 12px;
                            /* bottom: 30px; */
                            transition: opacity .2s ease-in-out;
                            -moz-transition: opacity .2s ease-in-out;
                            -webkit-transition: opacity .2s ease-in-out;
                        }

                        .jQueryMosaic > .item > .saveText > .texts {
                           /* position: absolute; */
                            left: 0px;
                            right: 0px;
                            bottom: 0px;
                            padding: 4px 14px 4px 14px;
                            background: rgba(87,87,89,0.7);
                            color: #fff;
                        }
                    </style>


                <div id="mosaic" class="mosaic" style="background: #F7F7F7;">

                @foreach ($latestPhotos as $key => $latestPhoto)
                    @if ($latestPhoto->status == 'on')

                    @php
                    $height = Image::make(storage_path('/app/public/photos/').$latestPhoto->image)->height();
                    $width = Image::make(storage_path('/app/public/photos/').$latestPhoto->image)->width();
                    @endphp
                    {{--  {{ $subcategoryId }}  --}}
                    <a class="item withImage" href="{{ url('/collection/image/'.$latestPhoto->category_id.'/'.$latestPhoto->id.'/'.$subcategoryId) }}" width={{ $width }} height={{ $height }}
                        style="background-color: #69DF7B;
                        background-image: url({{asset('storage/photos/'.$latestPhoto->image)}});" data-high-res-background-image-url="{{ asset('storage/photos/'.$latestPhoto->image) }}">
                        <div class="overlay">
                            <div class="texts">
                            <p style="margin-bottom: 4px;line-height: 17px;">{{ $latestPhoto->description  }}</p>
                        </div>
                    </div>

                        <div class="saveText">
                            <div class="texts rounded">
                            <p style="margin: 0px">
                                <span>
                                    +
                                </span>
                                <span>
                                    Save
                                </span>
                            </p>
                            </div>
                        </div>

                </a>

                    {{--  <div class="img zoom ">
                        <a href="{{ url('/products/singleImage/' . $latestPhoto->id ) }}">
                        <img src="{{ asset('storage/photos/'.$latestPhoto->image) }}" />
                        </a>
                        <p>{{ $latestPhoto->description  }}</p>
                      </div>  --}}
                    @endif
                @endforeach



        </div>
</div>








                </div>
        </div>
                </div>

                {{-- <script>
                    document.addEventListener('contextmenu', event=> event.preventDefault());
                    document.onkeydown = function(e) {
                    if(event.keyCode == 123) {
                    return false;
                    }
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                    return false;
                    }
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                    return false;
                    }
                    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                    return false;
                    }
                    }
                    </script> --}}

        @endsection
