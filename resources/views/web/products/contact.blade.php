@extends('layouts.web.app')
@section('content')

<div class="row" style="min-height: calc(100vh - 40px)">
    <div class="col-md-12">
<nav aria-label="breadcrumb">
<ol class="breadcrumb" style="padding-top: 20px;padding-left: 1%;border-bottom: 1px solid lightgray;">
<li class="breadcrumb-item">
    <a href="http://127.0.0.1:8000" style="color: black">Home</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="http://127.0.0.1:8000/pages/contact" style="color: black">Contact Us</a>
</li>
</ol>
</nav>

<div class="row-md-12" style="margin-top: 2%;">
<div class="row">
<div class="col" style="margin-left: 1%;">

    <span style="line-height: 29px;font-size: 20px;font-weight: 400;color: black;margin-left: 0.5%;">Contact Us</span>

<div class="row col-md-12" style="margin-bottom: 2%;    margin-top: 2%;">


<div class="col-8">

    <p>
        Don’t hesitate to get in touch with us. We welcome any feedback that helps us improve our product
        collection and website. For questions regarding the copyright of our images or license agreement
        please refer to the information in the footer.
        </p>

</div>
<div class="col-4" style="text-align: right">
    DAY Investments Ltd.<br />
    6 Clayton Street <br />
    Newmarket <br />
    Auckland 1023 <br />
</div>


</div>
<div class="row col-md-12">


<form>

    <div style="margin-bottom: 2%;">
    <input type="text" class="form-control" placeholder="Name" style="background-color: #E3E5E7;">
    </div>

    <div style="margin-bottom: 2%;">
    <input type="email" class="form-control" placeholder="Email" style="background-color: #E3E5E7;">
    </div>

    <div style="margin-bottom: 2%;">
    <textarea class="form-control" rows="5" id="comment" placeholder="Message" style="background-color: #E3E5E7;"></textarea>
    </div>


    <div style="">
    <button style="float: right;border-radius: 0;background: #03768F;" class="btn btn-primary btn-sm" type="submit">SEND</button>
    </div>


    </form>
</div>
</div>
<div class="col" style="text-align: right;">
<img src="https://cdn.shopify.com/s/files/1/3102/8110/files/nz-photos-contact-page-image.jpg?14597195113033344413" width="600px" height="400px" style="vertical-align: middle;
width: auto;
max-height: 370px;
border-radius: 50% 0 0 50%;">
</div>


</div></div>

</div></div>

@endsection
