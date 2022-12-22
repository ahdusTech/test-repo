<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Photo;
use App\User;
use Intervention\Image\Facades\Image;
use response;
use Imagick;
use Yajra\Datatables\Datatables;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->session_name = "logo_table";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_name = null)
    {
        if ($category_name == null) {
            $categories = Category::all();
        } else {
            $categories = Category::where('name','!=',$category_name)->get();
        }

        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Foto-ID',
                'sort' => true,
            ),
            'image' => array(
                'name' => 'Foto',
                'sort' => false,
            ),
            'status' => array(
                'name' => 'Aktiv?',
                'sort' => false,
            ),
            'description' => array(
                'name' => 'Beschreibung',
                'sort' => false,
            ),
            'category_id' => array(
                'name' => 'Kategorie',
                'sort' => false,
            ),
            'sub_category_id' => array(
                'name' => 'Unterkategorie',
                'sort' => false,
            ),
            'created_at' => array(
                'name' => 'Hochgeladenes Datum',
                'sort' => false,
            ),
            'action' => array(
                'name' => 'Aktion',
                'sort' => false,
            ),
        );

        return view('admin.photos.index', compact('categories', 'category_name'))->with($this->return_array);
    }

    public function getAllPhotos(Request $request)
    {
        // if ($request->has('value')) {
        //     dd($request->has('value'));
        // }

        // // jo searched kya uska category ka id
        $category_id = Category::where('name', $request->search['value'])->value('id');
        $category_name = $request->search['value'];
        $all_photos = Photo::query()->where('category_id', $category_id)->get();
        // dd($all_photos);

            return Datatables::of($all_photos)
                    ->addColumn('consecutive', function($row){
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->editColumn('id', function ($row) {
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 'on' ) {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                        } else {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                        }
                    })
                    ->addColumn('image', function ($row) {
                        return '<div style="text-align:center; padding-left:7px;height: 58px;">
                        <label data-href="' . route('get-modal-photo') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal">
                        <img src="' . asset('/images/photos/thumbnail/'.$row->small_thumbnail) . '" style="height:50px; margin-top:5px; margin-bottom:3px;"/></label>
                        </div>';
                    })
                    ->addColumn('description', function($row){
                        return '<p style="margin: 0px">' . $row->description . '</p>';
                    })
                    ->editColumn('category_id', function($row){

                        return '<p style="margin: 0px">' . $row->Category->name . '</p>';
                    })
                    ->editColumn('sub_category_id', function($row){
                        if($row->subcategory == null) {
                            return 'Keine Unterkategorie';
                        } else {
                        return '<p style="margin: 0px">' . $row->subcategory->name . '</p>';

                        }
                    })
                    ->addColumn('created_at', function($row){
                        return '<p style="margin: 0px">' . $row->created_at . '</p>';
                    })
                    ->addColumn('action', function ($row) use ($category_name) {
                        return '
                        <a href="' . url('admin/edit/photos', ['id' => $row->id, 'category_name' => $category_name ]) . '"
                        style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <label data-href="' . route('get-delete-modal-photo') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    })
                    ->rawColumns([
                        'id',
                        'consecutive',
                        'status',
                        'description',
                        'created_at',
                        'category_id',
                        'image',
                        'sub_category_id',
                        'action',
                        ])
                    ->make(true);

    }

    public function getDeleteLogoModaPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-logo.deleteLogoModalTitle');
        $return_array['id'] = $request->id;
        $photo_description = Photo::where('id', $return_array['id'])->value('description');
        //categories based on category_id of photo
        $category_id = Photo::where('id', $return_array['id'])->value('category_id');
        $category_name = Category::where('id', $category_id)->value('name');
        //category name as return array
        $return_array['category_name'] = $category_name;
        $return_array['name'] = $photo_description;
        return (string)view('logo-admin.delete-modal-photo')->with($return_array);
    }

     public function getLogoModaPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $photoId = $request->id;
        $photo = Photo::where('id', $photoId)->first();

        return view('logo-admin.modal-photo', compact('photo'));
    }

    public function deleteLogoProcessPhoto(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        Photo::deleteLogo($request->id);
        return redirect()->route('admin.photos', ['category_name' => $request->category_name])->with('success','Foto erfolgreich gelöscht');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCatName(Request $request, $name)
    {
        return response()->json(['name' => $name]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $name)
    {

        $category_name = $request->name;
        // dd($category_name);
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $sub_categories = SubCategory::with('category')
        ->where('category_id',$category_id)
        ->orderBy('sort', 'asc')
        ->get()->pluck('name', 'id')->prepend('Wählen Sie', '');

        return view('admin.photos.create', compact('category_id', 'category_name', 'sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
            'description' => 'required'
        ]);

        if($request->hasfile('image'))
         {

            $image = $request->file('image');
            $ImageNameresized= time().$image->getClientOriginalName();
            // $imgFileCollection = Image::make($image->getRealPath())->resize(888, 666);       //image resize from here;
            $imgFileCollection = Image::make($image->getRealPath());       //image resize from here;
            $imgFileCollection->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $height = $imgFileCollection->height();
            $width = $imgFileCollection->width();
            $pathOfOriginalImage = public_path() . '/images/photos/';
            $imgFileCollection->save($pathOfOriginalImage . $ImageNameresized);


            //upload file for small thmbnails
            $image = $request->file('image');
            $smallfilenametostore = time(). 'small_thumbnail '.$image->getClientOriginalName();

            //resize image in storage
            $smallthumbnailpath = public_path() . '/images/photos/thumbnail/';
            $smallthumbnail = Image::make($image->getRealPath());
            $smallthumbnail->resize(150, 93, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $smallthumbnail->save($smallthumbnailpath . $smallfilenametostore);


            //upload file with its original dpi values
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get extension
            $extension = $image->getClientOriginalExtension();
            //filename to store
            $ImageNameOriginal = $filename.'_original_'.time().'.'.$extension;
            //Upload File
            $originalPath = public_path() . '/images/photos/originalImage/';
            $OriginalImage = Image::make($image->getRealPath());
            $OriginalImage->save($originalPath . $ImageNameOriginal);




            //upload file with watermark and resized image with new variable single image
            $ImageNameWatermark= time().$image->getClientOriginalName();
            // dd($ImageNameWatermark);
            $SingleImage = Image::make($image->getRealPath())
            // dd($SingleImage);
            ->resize(900, 500, function($constraint)
            {
                $constraint->aspectRatio();

            });
            // dd($SingleImage);
            $pathOfWatermarkImage   = public_path() . '/images/photos/singleImage/';
            $watermarkPath          = public_path('frontend/img/logo.png');
            $watermark              = Image::make($watermarkPath)->resize(160, 30)->opacity(30);
            $wmarkWidth             = $watermark->width();
            $wmarkHeight            = $watermark->height();
            $imgHeight              = $SingleImage->height();
            $imgWidth               = $SingleImage->width();
            // dd($imgWidth, $imgHeight);

            // dd('panorama');
            $x                      = 20;
            $xx                     = 40;
            $y                      = 20;

            while ($x < $imgWidth) {
                $y = 20;
                $xx = $x;
                $line = 1;
                while($y < $imgHeight) {
                    if($line%2 == 0) {
                        $xx = $x+150;
                    }
                    $SingleImage->insert($watermark, 'top-left', $xx, $y);
                    $y += $wmarkHeight+100;
                    $xx = $x;

                    $line += 1;
                }

                  $x += $wmarkWidth+150;

            }

            // $SingleImage->save($pathOfWatermarkImage, 80); //for single image
            $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 80); //for single image


            //upload file without watermark and resized image edit images
            $WithoutWatermarkResized= time().$image->getClientOriginalName();
            $imgWithoutWatermarkResized = Image::make($image->getRealPath());
            $imgWithoutWatermarkResized->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfEditOriginalImage = public_path() . '/images/photos/originalResized/';
            // $imgWithoutWatermarkResized->save($pathOfEditOriginalImage); //for edit show images
            $imgWithoutWatermarkResized->save($pathOfEditOriginalImage . $WithoutWatermarkResized);



         }

        $form                  =    new Photo();
        $form->status          =    $request->status;
        $form->description     =    $request->description;
        $form->sub_category_id =    $request->sub_category_id;
        $form->category_id     =    $request->category_id;
        // $form->image=json_encode($data); //collection images
        $form->image           =    $ImageNameresized; //collection images
        //save small_thumbnail image name in database
        $form->small_thumbnail =    $smallfilenametostore;
        //save original_image name in database
        $form->original_image  =    $ImageNameOriginal;
        //save singleImage name in database of watermark
        $form->singleImage     =    $ImageNameWatermark;
         //save original resized image name in database
        $form->originalResized =    $WithoutWatermarkResized;

        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name = $categories->name;

        $form->save();


        return redirect()->route('admin.photos', [$category_name])
        ->with('success', 'Foto wurde erfolgreich hinzugefügt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $photo_id, $category_name)
    {
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $category_name = $categories->name;
        // dd($category_name);
        $photo = Photo::findOrfail($photo_id);
        $sub_categories = SubCategory::with('category')
        ->where('category_id',$category_id)
        ->get();
        return view('admin.photos.edit', compact('photo', 'sub_categories' ,'category_id', 'category_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:207048',
            'description' => 'required',
        ]);

        $photo                  = Photo::find($request->id);
        $photo->description     = $request->description;
        $photo->category_id     = $request->category_id;
        $photo->sub_category_id = $request->sub_category_id;

        if($request->input('status') == 'on')
        {
            $photo->status = 'on';
        } else {
            $photo->status = '';
        }

        if($request->hasfile('image') && $request->image != '')
        {
            $image_path           = public_path() . '/images/photos/' . $photo->image;
            //image path for small thumbnail
            $small_thumbnail_path = public_path() . '/images/photos/thumbnail/' . $photo->small_thumbnail;
            //image path for original image
            $original_image_path  = public_path() . '/images/photos/originalImage/' . $photo->original_image;
            //image path for single image
            $watermark_image_path = public_path() . '/images/photos/singleImage/' . $photo->singleImage;
            //image path for original resized image
            $original_resized_image_path = public_path() . '/images/photos/OriginalResized/' . $photo->originalResized;
            //if file exists delete multiple images
            if(File::exists($image_path) && File::exists($small_thumbnail_path)
                && File::exists($original_image_path)
                && File::exists($watermark_image_path)
                && File::exists($original_resized_image_path)
                ) {
                File::delete($image_path);
                File::delete($small_thumbnail_path);
                File::delete($original_image_path);
                File::delete($watermark_image_path);
                File::delete($original_resized_image_path);
            }

            $image                  = $request->file('image');
            $ImageNameCollection    = time().$image->getClientOriginalName();
            $imgFileCollection      = Image::make($image->getRealPath()); //image resize from here;
            $imgFileCollection->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $height = $imgFileCollection->height();
            $width = $imgFileCollection->width();
            $pathCollection         = public_path() . '/images/photos/';
            $imgFileCollection->save($pathCollection . $ImageNameCollection);


           //upload file for small thmbnails
           $image                  = $request->file('image');

           //filename to store
           $smallfilenametostore = time().'small_thumbnail' .$image->getClientOriginalName();
           //resize image in storage
           $smallthumbnailpath      = public_path() . '/images/photos/thumbnail/';
           $smallthumbnail          = Image::make($image->getRealPath());
            $smallthumbnail->resize(150, 93, function($constraint)
            {
                $constraint->aspectRatio();

            });
           $smallthumbnail->save($smallthumbnailpath . $smallfilenametostore);

           //upload file without watermark and original image
           $ImageNameOriginal       = time().$image->getClientOriginalName();
           $imgFileOriginal         = Image::make($image->getRealPath());       //image resize from here;
           $pathOfCollectionImage   = public_path() . '/images/photos/originalImage/';
           $imgFileOriginal->save($pathOfCollectionImage . $ImageNameOriginal);


            //upload file with watermark and resized image with new variable single image
            $ImageNameWatermark= time().$image->getClientOriginalName();
            $SingleImage = Image::make($image->getRealPath())
            ->resize(900, 500, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfWatermarkImage   = public_path() . '/images/photos/singleImage/';
            $watermarkPath          = public_path('frontend/img/logo.png');
            $watermark              = Image::make($watermarkPath)->resize(160, 30)->opacity(40);
            $wmarkWidth             = $watermark->width();
            $wmarkHeight            = $watermark->height();
            $imgHeight              = $SingleImage->height();
            $imgWidth               = $SingleImage->width();




            // dd('panorama');
            $x                      = 20;
            $xx                     = 40;
            $y                      = 20;

            while ($x < $imgWidth) {
                $y = 20;
                $xx = $x;
                $line = 1;
                while($y < $imgHeight) {
                    if($line%2 == 0) {
                        $xx = $x+150;
                    }
                    $SingleImage->insert($watermark, 'top-left', $xx, $y);
                    $y += $wmarkHeight+100;
                    $xx = $x;

                    $line += 1;
                }

                  $x += $wmarkWidth+150;

            }

            $SingleImage->save($pathOfWatermarkImage . $ImageNameWatermark, 80); //for single image


            //



            //upload file without watermark and resized image edit images
            $WithoutWatermarkResized= time().$image->getClientOriginalName();
            $imgWithoutWatermarkResized = Image::make($image->getRealPath());
            $imgWithoutWatermarkResized->resize(600, 340, function($constraint)
            {
                $constraint->aspectRatio();

            });
            $pathOfEditOriginalImage = public_path() . '/images/photos/originalResized/';
            $imgWithoutWatermarkResized->save($pathOfEditOriginalImage . $WithoutWatermarkResized); //for edit show images


        } else {
            $ImageNameCollection  = $photo->image;
            $smallfilenametostore = $photo->small_thumbnail;
            $ImageNameOriginal    = $photo->original_image;
            $ImageNameWatermark   = $photo->singleImage;
            $WithoutWatermarkResized = $photo->originalResized;
        }

        $photo->image           =    $ImageNameCollection;
        //update small_thumbnail image name in database
        $photo->small_thumbnail =    $smallfilenametostore;
        //update original_image name in database
        $photo->original_image  =    $ImageNameOriginal;
        //update singleImage name in database
        $photo->singleImage     =    $ImageNameWatermark;
        //update originalResized name in database
        $photo->originalResized =    $WithoutWatermarkResized;

        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name          =    $categories->name;


        $photo->update();
        return redirect()->route('admin.photos', [$category_name])
        ->with('success', 'Foto wurde erfolgreich aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
