@extends('layouts.web.app')
@section('content')

<style>
    p {
        font-size: 16px;
    }
</style>
<div class="row" style="min-height: calc(100vh - 40px)">
    <div class="col-md-12">
<nav aria-label="breadcrumb" style="font-size: 14px;">
<ol class="breadcrumb" style="border-bottom: 1px solid lightgray;padding: 13px 0px 9px 34px;font-size: 13px;color: lightgray;">
<li class="breadcrumb-item">
    <a href="http://127.0.0.1:8000" style="color: black">Home</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="http://127.0.0.1:8000/pages/about" style="color: black">About</a>
</li>
</ol>
</nav>

<div class="row-md-12">
<div class="row">
<div class="col" style="padding-left: 1.5%;margin-left: 1%;">
<span style="line-height: 29px;font-size: 18px;font-weight: 400;margin-bottom: 2%;display: block;margin-top: 2%;color: black;">About</span>


<div class="col" style="padding-top: 6px;">
<p style="color: black;">NZ.photos is a stock photography website dedicated to offer the highest quality images, photos and videos about New Zealand. </p>

<p style="color: black;">The whole team behind nz.photos is very passionate about New Zealand. We love this country and made it our goal to take, collect and offer only the best, high-resolution images of New Zealand.</p>

<p style="color: black;">Many other stock photo websites offer multiple different variants of every photo and cluttering up their sit with tons of unnecessary duplicates. We want to set ourselves apart from that and offer a very selective collection of photos.</p>

<p style="color: black;">We want our users to find the right photo for them right away without having to browse through paves of similar low quality images.  NZ.photos is here to bring New Zealand stock photos to the next level.</p>



</div>




</div><div class="col" style="text-align: right;">
<img src="https://cdn.shopify.com/s/files/1/3102/8110/files/nz-photos-contact-page-image.jpg?14597195113033344413" width="600px" height="400px" style="vertical-align: middle;
width: auto;
max-height: 370px;
border-radius: 50% 0 0 50%;">
</div>


</div></div>

</div>
</div>

@endsection
