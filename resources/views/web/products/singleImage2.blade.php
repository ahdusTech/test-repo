@extends('layouts.web.app')
@section('content')

<style>
    /* The container */
    .container {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;

    }

    /* Hide the browser's default radio button */
    .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;

    }

    /* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
      border-radius: 50%;
       border: 1px solid lightgrey;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
      background-color: white;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 8px;
    left: 8px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: blue;
    }


tr:hover {background-color: ghostwhite;}

.btn-primary:hover {
    background-color: darkgreen;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  width: 100%;
  max-width: 100%;
}

tr {

    font-weight: 600;
}

.nr {

    width: 20px;
}

.country {

    width: 20px;
}

.row tbody tr.highlight td {
    background-color: #efefef;
}


th, td {
    font-size: 15px;
    padding: 11px 3px 10px 5px;
}

td {
    padding: 5px
}

.details1 {
    display: block;
}


/* input[type=radio] {
height: 20px;
width: 20px;
vertical-align: middle;
} */
</style>
 <div class="tm-container-content row" style="background-color: white;">


             <div class="col-md-12">
    {{--  <nav aria-label="breadcrumb" style="border-bottom: solid 1px lightgray;margin-left: 2%;font-size: 15px;">
  <ol class="breadcrumb" style="padding-left: 0;margin-bottom: 0;background: none;">
    <li class="breadcrumb-item"><a href="{{ asset('/') }}" style="color: black;">Home</a></li>
    <li class="breadcrumb-item">
        <a href="#" style="color: black;">{{ $category->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $image->description }}</li>
  </ol>
</nav>  --}}
<style>

    .singleImage {
        {{--  display: flex;  --}}
        min-height: 400px; /* if you prefer */
        text-align: center;
        {{--  height: 535px;  --}}
        position: relative;
        display: flex;
    }
    .singleImage img {
        margin: auto;
            display: block;
           /*  width: 100%;  */
            max-width: 100%;
            /*  object-fit: cover;  */

    }

    .singleImage .prev {
        position: absolute;
    top: 45%;
    left: 2%;
    /* right: 6%; */
    /* transform: translate(-50%, -50%); */
    -ms-transform: translate(-50%, -50%);
    background-color: rgb(8,8,8);
    color: white;
    font-size: 25px;
    padding: 25px 18px 27px 19px;
    /* border: none; */
    cursor: pointer;
    border-radius: 5px;
    /* text-align: center; */
    z-index: 1;

      }

      .singleImage .prev:hover {
        background-color: black;
      }

      .singleImage .next {
        position: absolute;
        top: 45%;
        /* left: 0%; */
        right: 2%;
        /* transform: translate(-50%, -50%); */
        -ms-transform: translate(-50%, -50%);
        background-color: rgb(8,8,8);
        color: white;
        font-size: 25px;
        padding: 25px 18px 27px 19px;
        /* border: none; */
        cursor: pointer;
        border-radius: 5px;
        /* text-align: center; */
    z-index: 1;

    }

      .singleImage .next:hover {
        background-color: black;
      }

</style>

<style>

    .singleImage {
        min-height: 400px; /* if you prefer */
        text-align: center;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 500px;
    }

    .singleImage .image-wrapper:hover .expand-img{
        display: block;
    }

    .singleImage .expand-img {
        background-color: rgba(8,8,8,.6);
    border: 1px solid hsla(0,0%,40%,.4);
    border-radius: 5px;
    color: #fff;
    display: none;
    height: 50px;
    margin: auto;
    padding: 12px;
    position: absolute;
    right: 15px;
    top: 15px;
    width: 50px;
    cursor: pointer;
    }
    .singleImage .expand-img img{
        width: auto;
        height: auto;
    }
    .singleImage img {
        margin: auto;
            display: block;
           /*  width: 100%;  */
            max-width: 100%;
            /*  object-fit: cover;  */

    }

    .singleImage .prev {
        position: absolute;
    top: 45%;
    left: 2%;
    /* right: 6%; */
    /* transform: translate(-50%, -50%); */
    -ms-transform: translate(-50%, -50%);
    background-color: rgb(8,8,8);
    color: white;
    font-size: 25px;
    padding: 25px 18px 27px 19px;
    /* border: none; */
    cursor: pointer;
    border-radius: 5px;
    /* text-align: center; */
    z-index: 1;
      }

      .singleImage .prev:hover {
        background-color: black;
      }

      .singleImage .next {
        position: absolute;
        top: 45%;
        /* left: 0%; */
        right: 2%;
        /* transform: translate(-50%, -50%); */
        -ms-transform: translate(-50%, -50%);
        background-color: rgb(8,8,8);
        color: white;
        font-size: 25px;
        padding: 25px 18px 27px 19px;
        /* border: none; */
        cursor: pointer;
        border-radius: 5px;
        /* text-align: center; */
    }

      .singleImage .next:hover {
        background-color: black;
      }
      .image-wrapper {
        position: relative;
      }

      #fullpage {
        align-items: center;
        background-color: rgba(12, 13, 13, .8);
        display: none;
        height: 100%;
        justify-content: center;
        width: 100%;
        left: 0;
        overflow: hidden;
        position: fixed;
        top: 0;
        transition: all .25s ease-in;
        z-index: 100;

      }

      #fullpage .modal-image-wrapper {
        height: auto;
        left: 0;
        margin: 40px;
        max-height: 90vh;
        position: relative;
        top: 0;
        width: auto;
        margin-left: auto;
        margin-right: auto;
      }

      #fullpage .modal-image-wrapper .stock-photo-image{
        cursor: initial;
        cursor: initial;
        height: 90vh;
        max-height: 90vh;
        max-width: 90vw;
      }
      #fullpage .modal-image-wrapper .close-btn-icon {
        color: #fff;
        cursor: pointer;
        position: absolute;
        right: -35px;
        top: -35px;
        width: 34px;
        z-index: 101;
        font-size: 26px;

      }

      .singleImage .image-wrapper:hover{
        cursor: zoom-in;
    }

    .singleImage .image-wrapper:hover .expand-img{
        cursor: zoom-in;
        display: block;
    }
    .singleImage .image-wrapper:hover{
        cursor: zoom-in;
    }

</style>

  <div class="row" style="margin: 28px 28px 30px 28px;">
     <div class="col-md-7 SingleImage" style="background: #E8EAED;">

                <a href="{{ url('/collection/image2/'.$image->category_id.'/'.$nextID) }}"
                    @if($nextID == null) style="display: none" @endif
                    class="prev text-xl; color:rgb(68, 68, 68) !important">
                    <i class="fa-solid fa-angle-left"></i>
                </a>

        {{--  <img src="{{asset('storage/photos/singleImage/'.$image->singleImage)}}">  --}}

        <div class="image-wrapper">
            <div class="expand-img" role="button" >
                <img src="{{ asset('frontend/img/zoom-hover-3.png') }}" alt=""></div>
                <img id="myImg" src="{{asset('storage/photos/singleImage/'.$image->singleImage)}}">
            </div>


        <div class="expand-img" role="button" >
            <img src="{{ asset('frontend/img/zoom-hover') }}">
            {{--  <i class="fa-regular fa-arrow-up-right-and-arrow-down-left-from-center"></i>  --}}
        </div>

           {{-- Next Page Link --}}

            <a href="{{ url('/collection/image2/'.$image->category_id.'/'.$previousID) }}"
                @if($previousID == null) style="display: none" @endif
                class="next text-xl; color:rgb(68, 68, 68) !important"> <i class="fa-solid fa-angle-right"></i>
            </a>



    </div>


    <div id="fullpage" onclick="this.style.display='none';" role="button" aria-label="close" tabindex="0">
        <div class="modal-image-wrapper">
          <div role="button" tabindex="0">
            <img class="stock-photo-image" src="" alt="" />
          </div>
          <div class="close-btn-icon">x</div>
        </div>
      </div>

    <div class="col-md-5" style="border: 1px solid lightgray;padding: 1%;">
        <p style="font-size: 17px;font-weight: 500;">
            Buy this stock image now…
        </p>
   <p style="border-bottom: 3px solid lightgray;padding-bottom: 10px;font-size: 17px;">Royalty free licenses</p>
   <table id="userTable">
    <tbody>
        <tr id="$52.00 XSmall">
          <td>
            <label class="container"> XSmall <br>
                <span class="details" style="font-size: 11px;display: none">
                    457 x 300 px 16.1 x 10.6 cm (72 dpi) 401.7 KB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $52.00

          </td>

        </tr>
        <tr id="$100.00 Small">
          <td>
            <label class="container"> Small <br>
                <span class="details" style="font-size: 11px;display: none">
                    675 x 444 px 23.8 x 15.7 cm (72 dpi) 878 KB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $100.00 </td>

        </tr>
        <tr id="$200.00 Medium">
          <td>
            <label class="container"> Medium <br>
                <span class="details" style="font-size: 11px;display: none">
                    1407 x 924 px 23.8 x 15.6 cm (150 dpi) 3.7 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>

          <td style="text-align: center;"> $200.00 </td>

        </tr>
        <tr id="$258.00 Large">
          <td>
            <label class="container"> Large <br>
                <span class="details" style="font-size: 11px;display: none">
                    2813 x 1847 px 23.8 x 15.6 cm (300 dpi) 14.9 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>

          <td style="text-align: center;"> $258.00 </td>

        </tr>
        <tr id="$331.00 XLarge">
          <td>
            <label class="container"> XLarge <br>
                <span class="details" style="font-size: 11px;display: none">
                    3750 x 2463 px 31.8 x 20.9 cm (300 dpi) 26.4 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $331.00 </td>

        </tr>
        <tr id="$384.00 XXLarge">
          <td>
            <label class="container"> XXLarge <br>
                <span class="details" style="font-size: 11px;display: none">
                    5000 x 3284 px 42.3 x 27.8 cm (300 dpi) 47 MB
                </span>
              <input type="radio" name="product_variation">
              <span class="checkmark"></span>
            </label>
            </td>
          <td style="text-align: center;"> $384.00 </td>

        </tr>
      </tbody>
  </table>

  <p style="text-align: center;">
    <button id="btnRowClick"  class="btn btn-primary"
    style="font-weight: 700;background-color: springgreen;color: black;border: 1px solid;
    width: 100%;border-radius: 77px;font-size: 18px;"> buy now &gt; </button>
</p>

<p style="text-align: center;">
    <button class="btn btn-primary" style="
    font-weight: 700;
    background-color: white;
    color: black;
    border: 1px solid;
    width: 100%;
    border-radius: 77px;font-size: 18px;">add to cart</button>
</p>

{{-- <input type="button" id="tst" value="OK" onclick="fnselect()" /> --}}

</div>

</div>



   </div>

  <div class="imageDetails col-sm-6" style="margin-left: 2%;">
    <table>
         <tbody>
        <tr>
            <td style="font-weight: bold;">IMAGE DETAILS</td>

         </tr>


         <tr>
            <tr>
                <td>image-id:</td>
                <td>{{ $image->id }}</td>
             </tr>
            <td>Dimensions:</td>
            <td>
                {{ $imageWidth }} x {{ $imageHeight }}

                <?php
                    //$inchewidth = $imageWidth * 0.010417;
                    //$inchehight = $imageHeight * 0.010417;

                    //$cmwidth = $imageWidth * 0.026;
                    //$cmheight = $imageHeight * 0.026;

                    // 1 inch has 96 pixels
                    //calculate the DPI of the image
                    //$dpi = $imageWidth / $inchewidth;

                    //calculate the the dpi in height
                    //$dpih = $imageHeight / $inchehight;


                ?>


                {{--  {{ round($cmwidth, 2) }} x {{ round($cmheight, 2) }} cm  --}}


            </td>
         </tr>


         <tr>
            <td>Width:</td>
            <td>{{ $imageWidth }} pixel</td>
         </tr>
         <tr>
            <td>Height:</td>
            <td>{{ $imageHeight }} pixel</td>
         </tr>
         <tr>
                @switch($horizontalDPI)
                  @case(0)
                @break

                @default
                <td>Horizontal Resolutions:</td>
                <td>
                    {{ $horizontalDPI }} dpi
                </td>

                @endswitch
         </tr>
         <tr>
                @switch($verticalDPI)
                    @case(0)
                @break

                @default
            <td>
                Vertical resolutions:
            </td>
            <td>
                    {{ $verticalDPI }} dpi
            </td>
                @endswitch

         </tr>
        {{--  <tr>
            <td>Bit depth:</td>
            <td> 24 </td>
         </tr>  --}}


      </tbody>
    </table>

  </div>
</div>

             <!-- row -->

        <!-- container-fluid, tm-container-content -->

{{-- script for buy button --}}
        <script type="text/javascript">
          $(function() {
            $('#userTable').on('click', 'tbody tr', function(event) {
                $(this).addClass('highlight').siblings().removeClass('highlight');
                $(this).find('td input[type=radio]').prop('checked', true);



                //document.getElementById('details').style.display = 'block';


            });

            $('#btnRowClick').click(function(e) {
              var rows = getHighlightRow();
              if (rows != undefined) {
                // alert(rows.attr('id'));
              }
            });

            var getHighlightRow = function() {
              return $('table > tbody > tr.highlight');
            }

          });
        </script>

        <script>
            const imgs = document.querySelectorAll(".SingleImage .image-wrapper img");
            const showImgdiv = document.querySelector("#fullpage .modal-image-wrapper .stock-photo-image");
            const fullPage = document.querySelector("#fullpage");
            console.log('imgs', imgs)
            imgs[1]?.addEventListener("click", function () {
              showImgdiv.src = imgs[1]?.src;
              fullPage.style.display = "flex";
            });
            imgs[0]?.addEventListener("click", function () {
              showImgdiv.src = imgs[1]?.src;
              fullPage.style.display = "flex";
            });

          </script>

{{-- end buy button script --}}

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
