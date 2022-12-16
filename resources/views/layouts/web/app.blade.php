<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NZ.Photos New Zealand Stockphotos</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/stocfoto.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/css/all.min.css') }}">
      {{--  <link rel="stylesheet" href="{{ asset('frontend/css/templatemo-style.css') }}">  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    {{--    --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('flex2/jquery-mosaic/jquery.mosaic8e0e.css?v=8') }}"/>
	<script type="text/javascript" src="{{ asset('flex2/jquery-mosaic/jquery.mosaic8e0e.js?v=8') }}"></script>
	<script type="text/javascript" src="{{ asset('flex2/res/js/mainbea6.js?v=7') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('flex2/jquery.mosaic.css') }}" />
    <script type="text/javascript" src="{{ asset('flex2/jquery.mosaic.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{--    --}}

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style type="text/css">
    @font-face {
        font-family: 'monseratlight';
        src: url('{{ asset('fonts/Montserrat-VariableFont_wght.ttf') }}');
    }

    </style>

<style>

    @media (max-width: 1326px) {
        .logoStoc {
            padding: 5px 5px 5px 23px;
            width: 30%;

        }
        .mainMenuCat {
            background: white;
            padding: 0px 0px 0px 20px;
            display: flex;
        }
    }

    .logoStoc {
        padding: 5px 5px 5px 4px;
        width: 30%;
    }
     .mainMenuCat {
        background: white;
        display: flex;
        padding-left: 1%;
    }


</style>

<style>

    form.example input[type=text] {
        padding: 5px 10px 5px 10px;
        border: 1px solid grey;
        float: left;
        width: 95%;
        border-right: none;
        box-sizing: border-box;
    }

    form.example button {
          /* width: 3%; */
          padding: 6px 0px 7px 0px;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        cursor: pointer;
         box-sizing: border-box;
    }

    form.example::after {
      content: "";
      clear: both;
      display: table;
    }
    </style>


    <style>


.searchBox {
    color: #555;
    display: flex;
    border: 1px solid rgb(186,186,186);
    border-radius: 5px;
    width: 77%;
      margin: 0 auto;
      height: 31px;
  }

  input[type="search"] {
    border: none;
    background: white;
    margin: 0;
    padding: 7px 8px;
    font-size: 14px;
    font-family: 'monseratlight';
    color: inherit;
    border-radius: inherit;
    width: 95%;
  }

  button[type="submit"] {
    border: 1px solid transparent;
    border-radius: inherit;
  }

  button[type="submit"]:hover {
    opacity: 1;
  }

  button[type="submit"]:focus,
  input[type="search"]:focus {
    box-shadow: 0 0 3px 0 #1183d6;
    border-color: #1183d6;
    outline: none;
  }

  form.nosubmit {
   border: none;
   padding: 0;
  }

  input.nosubmit {
    border: 1px solid #555;
    width: 100%;
    padding: 9px 4px 9px 40px;
     background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
  }

  button[type="submit"]:focus, input[type="search"]:focus {
     box-shadow: none;
     border-color: white;
  }
    </style>

<body style="background: #F7F7F7;overflow-x: hidden;position: relative">

    <nav class="navbar navbar-expand-lg" style="background: rgb(253,253,253);;margin: 0;padding: 10px 15px 10px 15px;">
        <div style="margin-left: 0;width: 100%;display: flex;">
            <div class="logoStoc">
                <div style="width: 194px;">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('frontend/img/newlogo.png') }}" style="width: 194px;">
                    </a>
                </div>

            </div>

            {{--  <div class="main">

                <!-- Actual search box -->
                <!-- Another variation with a button -->
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="button">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>


              </div>  --}}
              <div style="
              width: 40%;
              margin-top: 17px;
          ">
                <form class="searchBox">
                <input type="search" placeholder="Search...">
                <button type="submit" style="
                background: white;
                padding: 4px;
            ">
                    <i class='fas fa-search fa-rotate-90' style="
                    font-size: 19px;
                    background-color: white;
                    color: rgb(186,186,186);
                "></i></button>
              </form>

              </div>





            <div id="navbarSupportedContent"
            style="width: 30%;text-align: right;padding: 18px 19px 10px 0px;">
                {{--  <ul class="navbar-nav">
                <li class="nav-item" style="text-align: right;padding-top: 11px;">
                    <a href="{{ route('customer.login_form') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;padding: 0;">
                        Sign in </a>
                        <br />
                        <a href="{{ route('customer.register') }}" style="color: #2f2d2e;font-size:11.9px;font-weight: 700;padding: 0;">
                        New Account
                    </a>
                </li>

                <span style="font-size: 25px;padding: 4px;color: lightgray;">|</span>
                <li class="nav-item">
                    <a class="nav-link nav-link" href="#" style="margin-top: 10%;font-size: 14px;">
                        <i style="padding-right: 5px;" class="fas fa-shopping-cart"></i>CART
                    </a>
                </li>  --}}

                <a href="#" class="btn btn-primary" style="border: none;background: rgb(253,253,253);color: rgb(8,8,8);font-weight: 500;
                font-family: monseratlight;padding: 8.5px 0px 6px 10px;">
                    <i class="fa-solid fa-clone" style="font-size: 11px;"></i>&nbsp; BOARDS
                </a>
                <a href="#" class="btn btn-primary" style="border: none;background: rgb(253,253,253);color: rgb(8,8,8);font-weight: 500;
                font-family: monseratlight;padding: 8.5px 10px 8px 10px;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 11px;"></i>&nbsp; BASKET
                </a>
                <a href="{{ route('customer.login_form') }}" class="btn btn-primary"
                style="border: 1px solid rgb(8,8,8);color: rgb(8,8,8);font-weight: 500;
                font-family: monseratlight;padding: 7px 18px 7px 18px;">
                    SIGN IN
                </a>
            </ul>


            </div>
        </div>
    </nav>
<style>
    a.active{
color: #048ba8;
}

a:hover {
text-decoration: none;
}

a:focus {
    text-decoration: none;


}
.AllCategories {
    color: black;
    display: block;
    margin-top: 0.25%;
    font-size: 15px;

}

.ActiveGreenColor {

    color: #048ba8;
    display: block;
    margin-top: 0.25%;
    font-size: 15px;

}

input[type=search] {

    outline-offset: 0px;

}

</style>

<style>
    ul{
        padding: 0;
        list-style: none;
        background: #f2f2f2;
    }
    ul li a{
        display: block;
        padding: 2px 6px 0px 9px;
        color: #555555 !important;
        text-decoration: none;
        border-bottom: 3px solid transparent;
        font-family: system-ui;
    }
    ul li{
        position: relative;
    }
    .list-inline li a:hover{
        /* display: block; */
        /* padding: 2px 6px 0px 9px; */
        /* color: #222222 !important; */
        /* background-color: #FFFFFF; */
        /* padding-top: 10px !important; */
        /* padding-bottom: 6px !important; */
        /* height: 24px !important; */
        border-bottom: 3px solid #8daf62;
        /* outline: 3px solid #57DBD7; */
        /* outline-offset: -1px; */
        /* opacity: 1.0; */
        /* text-shadow: none; */
        /* margin-top: 0px; */
        /* transition: background-color 0.250s; */
    }

    .list-inline li a.active{
        text-decoration: underline;

    }

    .nav-link {
        /* display: block; */
        padding: 0.5rem 10px 10px 2px;
        text-decoration: none;
        /* transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out; */
        transition: color .15s ease-in-out;
        color: black;
        font-size: 15px;
    }

    .dropdown li a:hover {
        text-decoration: underline;
        border: none;

    }
    .dropdown li a {
        display: initial;
    padding: 0px;
    text-decoration: none;
    font-size: 10pt;
    font-family: 'monseratlight';
    font-weight: normal;
    color: black;
    line-height: 18px;
    border-bottom: 3px solid transparent;
    text-transform: capitalize;
    }

    .dropdown li {

    }
    ul li ul.dropdown {
        min-width: 225px;
        background: #f2f2f2;
        display: none;
        position: absolute;
        z-index: 999;
        /* top: 34px;  */
        margin-top: 0px;
        border: 1px solid #AAAAAA;
        border-top: 1px solid #AAAAAA;
        /* box-shadow: 0px 5px 25px -15px #eeeeee; */
        /* position: absolute; */
        /* box-sizing: border-box; */
        /* width: 100%; */
        left: 6px;
        /* top: 0px; */
        /* z-index: 2000; */
        padding: 25px 20px 25px 25px;
        /* margin-top: -1px; */
        /* visibility: hidden; */
        border: 1px solid #A6A6A6;
        /* background-color: #FFFFFF; */
      }
    ul li:hover ul.dropdown{
        display: block;	/* Display the dropdown */
        background: white;
    }

    .list-inline {
        /* padding-left: 0; */
        list-style: none;
        margin-left: 0px !important;
        background: white;

        /* for strokes of the menus */
        border-top: 1px solid rgb(231, 231, 231);
    border-bottom: 1px solid rgb(231, 231, 231);
        margin: 0;
        padding-left: 19px;
        background-color: rgb(255,255,255);
            /* menu strokes */

    }
    .list-inline>li {
        /* display: inline-block; */
        /* padding-right: 5px; */
        float: left;
        /* padding: 0px; */
        /* margin: 0px; */
        /* list-style: none; */
        font: 10pt arial;
        padding: 5px 14px 0px 6px;
    }
    .list-inline>li>a {
    font-family: 'monseratlight';
    /* padding: 9px 6px 8px 0px */;
    font-size: 14px;

    }
    .nav-link {
        padding: 0.5rem 0 10px;
    }
    ul li:hover a.borderBottom {
        border-bottom: 3px solid #8daf62;
    }

    .btn-primary {
        color: black;
        font-family: inherit;
        background-color: white;
        font-weight: 600;
        font-size: 14px;
    }
    .btn-primary:hover {
        color: black;
        background-color: white;
    }
    .btn-primary:active:focus {
        color: black;
        background-color: white;
        border: none;
    }
    .btn-primary:active {
        color: black;
        background-color: white;
        border: none;
    }
    .btn-primary.focus, .btn-primary:focus {
        color: black;
        background-color: white;
        border: none;
        box-shadow: none;
    }

    input:focus-visible {
        outline: 1px solid white;
    outline-offset: -2px;
    }
    :focus-visible {
        outline: 1px solid white;
        outline-offset: -2px;
    }
    button:focus {
        /* outline: 1px dotted; */
        outline: 0px auto -webkit-focus-ring-color;
    }
</style>

    <div class="row" style="margin: auto;background: white;">

                <ul class="list-inline">
                    <li>
                        <a href="{{ route('Newest.Collection') }}" class="nav-link {{ (request()->is('Newsest-collection')) ? 'active' : '' }}">
                            Newest
                        </a>
                    </li>
                @foreach ($categories as $category )

                @if ($category->status == 'active')
                {{--  //get subcategories of category  --}}
                @php
                $subcategories = App\Subcategory::where('category_id', $category->id)->orderBy('sort', 'asc')->get();
                $active = 0;
                foreach ($subcategories as $subcategory)
                {
                    if (($category->id==$categoryId) && (request()->is('collections-photo/cat-id/'.$categoryId.'/cat/'.$categoryName.'/sub-id/'.$subcategory->id.'/sub/'.$subcategory->name)))
                    {
                       $active = 1;
                    }
                }

                @endphp

                {{--  //check if category has subcategories  --}}
                @if (count($subcategories) > 0)
                <li>

                    <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}"
                        class="nav-link {{ (request()->is('collections/' . $category->id . '/' . $category->name  ) || $active==1) ? 'active' : '' }} borderBottom">
                        {{ $category->name }}
                    </a>
                    <ul class="dropdown">
                        @foreach ($subcategories as $subcategory)
                        @if ($subcategory->status == 'active')
                        <li>
                        <a class="nav-link {{ (request()->is('collections-photo/cat-id/'.$categoryId.'/cat/'.$categoryName.'/sub-id/'.$subcategory->id.'/sub/'.$subcategory->name)) ? 'active' : '' }}"
                        href="{{ route('photo.collections',['categoryId' =>$category->id,'categoryName' => $category->name,'subcategoryId' => $subcategory->id,'subcategoryName' => $subcategory->name]) }}">
                            {{ $subcategory->name }}
                        </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @else

                <li>
                    <a href="{{ url('collections/' . $category->id . '/' . $category->name  ) }}" class="nav-link {{ (request()->is('collections/' . $category->id . '/' . $category->name  )) ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endif
                @endif
                @endforeach
            </ul>

    </div>

    {{--  <! -- container -->  --}}
    @yield('content')
    {{--  <!-- container-fluid, tm-container-content -->  --}}


    <footer
    @if (request()->is('collections/*') || request()->is('collections-photo/cat-id/*'))
    style="display: flex;font-size: 14px;background-color: #444;
    padding: 2%;height: 102px;position: absolute;width: 100%;"
    @else
    style="display: flex;font-size: 14px;background-color: #444;
    padding: 2%;height: 102px;position: absolute;width: 100%;"
    @endif


    >


        <div class="col-md" style="color: white;">
            Copyright © 2002-2022 DAY Investments Ltd. – All rights reserved
        </div>
        <div class="col-auto" style="font-size: 16px">

               <a href="{{ url('pages/about')}}" style="font-size: 13px;color: white"> About </a>
               <span><span> <a href="{{ url('pages/contact')}}" style="margin-left: 5px;font-size: 13px;color: white;"> Contact </a> </span></span>
               <span> <a href="{{ url('pages/lisence') }}" style="margin-left: 5px;font-size: 13px;color: white"> Lisence Terms </a> </span>
               <span> <a href="{{ url('pages/copyright') }}" style="margin-left: 5px;font-size: 13px;color: white"> Copyright </a> </span>
                <span> <a href="{{ url('pages/privacy') }}" style="margin-left: 5px;font-size: 13px;color: white"> Privacy Policy </a> </span>
        </div>
    </footer>
</body>
</html>

