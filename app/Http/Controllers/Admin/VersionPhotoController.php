<?php

namespace App\Http\Controllers\Admin;

use App\VersionPhoto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Photo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class VersionPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $photo_id, $counter, $color)
    {
        // dd($photo_id, $counter, $color);

        //get category_name based on photo_id
        $category_name = Photo::find($photo_id)->category->name;
        // dd($category_name);



        return view('admin.version_photos.create', compact('photo_id', 'counter', 'color', 'category_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $photo_id = $request->photo_id;
        // $photo_counter = 1;
        // dd($photo_counter);
        $category_name = $request->category_name;

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
            'description' => 'required'
        ]);

        if($request->hasfile('image'))
         {

            $image = $request->file('image');
            $WatermMarked_image= time().$image->getClientOriginalName();
            $imgFileCollection = Image::make($image->getRealPath());       //image resize from here;
            $imgFileCollection->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $height = $imgFileCollection->height();
            $width = $imgFileCollection->width();
            $pathOfOriginalImage = public_path() . '/images/version_photos/';
            $imgFileCollection->save($pathOfOriginalImage . $WatermMarked_image);


            // upload file for small thmbnails
            $image = $request->file('image');
            $smallfilenametostore = time(). 'small_thumbnail '.$image->getClientOriginalName();

            //resize image in storage
            $smallthumbnailpath = public_path() . '/images/version_photos/thumbnail/';
            $smallthumbnail = Image::make($image->getRealPath());
            // dd($smallthumbnail);

            $smallthumbnail->resize(150, 93, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $smallthumbnail->save($smallthumbnailpath . $smallfilenametostore);



            //upload file with watermark and resized image with new variable single image
            // $image = $request->file('image');
            // $pathOfWatermarkImage   = public_path() . '/images/photos/singleImage/';
            // $ImageNameWatermark= time() . '_watermakrkedImage_' .$image->getClientOriginalName();

            // $SingleImage = Image::make($image->getRealPath());


            // // dd($SingleImage);

            // $SingleImage->resize(900, 500, function($constraint)
            // {
            //     $constraint->aspectRatio();

            // });
            // // dd($SingleImage);


            // $watermarkPath          = public_path('frontend/img/logo.png');
            // $watermark              = Image::make($watermarkPath)->resize(160, 30)->opacity(30);
            // $wmarkWidth             = $watermark->width();
            // $wmarkHeight            = $watermark->height();
            // $imgHeight              = $SingleImage->height();
            // $imgWidth               = $SingleImage->width();
            // // dd($imgWidth, $imgHeight);

            // // dd('panorama');
            // $x                      = 20;
            // $xx                     = 40;
            // $y                      = 20;

            // while ($x < $imgWidth) {
            //     $y = 20;
            //     $xx = $x;
            //     $line = 1;
            //     while($y < $imgHeight) {
            //         if($line%2 == 0) {
            //             $xx = $x+150;
            //         }
            //         $SingleImage->insert($watermark, 'top-left', $xx, $y);
            //         $y += $wmarkHeight+100;
            //         $xx = $x;

            //         $line += 1;
            //     }

            //       $x += $wmarkWidth+150;

            // }

            // $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 80); //for single image


            //upload file without watermark and resized image edit images
            // $WithoutWatermarkResized= time().$image->getClientOriginalName();
            // $imgWithoutWatermarkResized = Image::make($image->getRealPath());
            // $imgWithoutWatermarkResized->resize(600, 340, function($constraint)
            // {
            //     $constraint->aspectRatio();

            // });
            // $pathOfEditOriginalImage = public_path() . '/images/photos/originalResized/';
            // // $imgWithoutWatermarkResized->save($pathOfEditOriginalImage); //for edit show images
            // $imgWithoutWatermarkResized->save($pathOfEditOriginalImage . $WithoutWatermarkResized);


            //upload file with its original dpi values
            //filename to store
            $originalImage = $request->file('image');
            $ImageNameOriginal = time().'_original_'.$originalImage->getClientOriginalName();
            $originalPath = public_path() . '/images/version_photos/originalImage/';

            $originalImage->move($originalPath, $ImageNameOriginal);



         }

        $version_photo                       =    new VersionPhoto();
        $version_photo->status               =    $request->status;
        $version_photo->photo_id             =    $photo_id;
        $version_photo->description          =    $request->description;
        $version_photo->color                =    $request->color;
        // dd($request->color);
        // $version_photo->sub_category_id   =    $request->sub_category_id;
        // $version_photo->category_id       =    $request->category_id;

        $version_photo->WatermMarked_image   =    $WatermMarked_image; //collection images
        //save small_thumbnail image name in database
        $version_photo->small_thumbnail   =    $smallfilenametostore;
        //save original_image name in database
        $version_photo->original_image       =    $ImageNameOriginal;
        //save singleImage name in database of watermark
        // $version_photo->singleImage     =    $ImageNameWatermark;
         //save original resized image name in database
        // $version_photo->originalResized =    $WithoutWatermarkResized;

        //save color to database
        // if($request->color == 'Farbe'){
        //     $version_photo->color = 'C';
        // }elseif($request->color == 'Schwarz/Weiß'){
        //     $version_photo->color = 'B';
        // } else{
        //     $version_photo->color = 'S';
        // }
        // dd($version_photo->color);

        $photo_counter = $request->counter;

        $last_version_photo = VersionPhoto::where('photo_id', $photo_id)->orderBy('counter', 'desc')->first();
        // dd($last_version_photo);
        if(!$last_version_photo){
            ++$photo_counter;
            $version_photo->counter = $photo_counter;

        }else{
            $version_photo->counter = $last_version_photo->counter + 1;
        }

        //if counter less than 10 then add 0 before counter
        if($version_photo->counter < 10){
            $version_photo->counter = '0'.$version_photo->counter;
        }
        $version_photo->image_name = 'nzphotos-'.$version_photo->color.$photo_id.$version_photo->counter.'-original.jpg';

        $version_photo->save();

        // dd($version_photo->color);

        if($version_photo->color == 'C'){
            $color = 'Farbe';
        }elseif($version_photo->color == 'B'){
            $color = 'color';
        }else{
            $color = 'Sepia';
        }

        return Redirect::to('admin/edit/photos/'. $photo_id . '/' . $category_name . '#'. $color);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(VersionPhoto $versionPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function edit(VersionPhoto $versionPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VersionPhoto $versionPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VersionPhoto  $versionPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $category_name, $photo_id, $color)
    {
        // dd($id, $category_name, $photo_id , $color);

        $version_photo = VersionPhoto::find($id);


        if($version_photo->color == 'C'){
            $color = 'Farbe';
        }elseif($version_photo->color == 'B'){
            $color = 'color';
        }else{
            $color = 'Sepia';
        }

        $version_photo->delete();
         return back()->with('success', 'Version Photo deleted successfully');



    }

    public function updateStatus(Request $request)
    {
        // dd($request->input('id'), $request->input('status'));
        $version_photo = VersionPhoto::find($request->input('id'));
        $version_photo->status = $request->input('status');
        // dd($version_photo->status);
        $counter = $version_photo->counter;
        $version_photo->save();
        //send different response based on status
        if($version_photo->status == 'on'){
            $status = 'Active';
            $message = 'Version Photo ist jetzt aktiv';
        }else{
            $status = 'Inactive';
            $message = 'Version Photo ist jetzt inaktiv';
        }
        return response()->json(['status'=>$status, 'message'=>$message, 'counter'=>$counter]);
    }
}
