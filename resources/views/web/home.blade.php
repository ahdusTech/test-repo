@extends('layouts.web.app')
@section('content')


<style>

img:hover {
    -webkit-filter: brightness(110%);

}

a:hover h2 {
    //display: block !important;
}

@media (max-width:425px) {
    .diffScreen {
        width: 50%;
    }

    .caption {
        margin-top: -34px !important;
         display: block !important;
         font-family: 'monseratlight';

    }
}

.caption {
    margin-top: -36px;
    margin-left: 19px;
    color: white;
    z-index: 1;
    font-family: 'monseratlight';
    font-size: 18px;


}


</style>

<div style="padding: 36px 36px 20px 32px;background: rgb(253,253,253);">

    <div class="row">
        @foreach ($categories as $category )
        @if ($category->status == 'active')
        <div class="col-xl-2 col-lg-3 col-md-5 col-sm-5 col-12 diffScreen" style="margin-bottom: 25px;padding-right: 10px;">
            <a href="{{ url('collections/' . $category->id . '/' . $category->name) }}" >
                <figure>
                    {{--  <img oncontextmenu=return!1 src="{{ url('/storage/'. $category->image) }}" alt="Image" class="img-fluid" style="width: 100%;">  --}}
                    <img src="{{ url('/images/categories/'. $category->image) }}" alt="Image" class="img-fluid" style="width: 100%;border-radius: 16px;">
                    <figcaption class="d-flex align-items-left justify-content-left">
                        <h2 class="caption">{{ $category->name }}</h2>
                    </figcaption>
                </figure>
            </a>
        </div>
    {{-- @endif --}}
        @endforeach
        </div>


</div>
{{--  <script>
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
    </script>  --}}

@endsection
