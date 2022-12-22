<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Photo;
use Intervention\Image\Facades\Image;



class frontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $categoryId = '';
        $subCategoryId = '';
        $categoryName   = '';

        // $subcategories = SubCategory::all();
        // $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();


        return view('web.home', compact('categories', 'categoryId', 'subCategoryId', 'categoryName'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function collections(Request $request, $categoryId, $categoryName, $subcategoryId = null)
    {

        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();
        //get all photos of this category with latest added first and paginate
        $latestPhotos  = Photo::where('category_id', $categoryId)->orderBy('created_at', 'desc')->paginate(12);
        // dd($latestPhotos);

        return view('web.products.collection', compact('categories', 'latestPhotos' , 'categoryId' ,'subcategories', 'subcategoryId' ,'categoryName'));

    }
    //function for photo_collections
    public function photo_collections(Request $request, $categoryId, $categoryName, $subcategoryId, $subcategoryName)
    {
        // dd($subcategoryId);
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::where('category_id', $categoryId)->orderBy('sort', 'asc')->get();
        //get all photos of this category with latest added
        $latestPhotos = Photo::where('category_id', $categoryId)->where('sub_category_id', $subcategoryId)->orderBy('created_at', 'asc')->paginate(12);
        //if latestPhotos is empty then show message
        if($latestPhotos->isEmpty()){
            $message = "Keine Fotos gefunden";
        }else{
            $message = "";
        }

        return view('web.products.photo_collection', compact('categories', 'subcategoryId' ,'message' ,'latestPhotos' , 'categoryId' ,'subcategories','categoryName', 'subcategoryName'));

    }

    //make function for NewestCollection
    public function NewestCollection(Request $request)
    {

        $categoryId = '';
        $subCategoryId = '';
        $categoryName   = '';
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategories = SubCategory::all();

        return view('web.products.newest_collection' , compact('categoryId', 'subCategoryId', 'categoryName', 'categories', 'subcategories'));
    }

    public function singleImage(Request $request, $categoryId, $image_id, $subcategoryId = null)
    {
        // dd($subcategoryId);
        $image         = Photo::findorfail($image_id);
        //sorage path
        $public_path   = public_path() . '/images/photos/originalImage/' . $image->original_image;

        //getImageResolution from Imagick
        $imageDPI = new \Imagick($public_path);
        //get image width
        $imageWidth = $imageDPI->getImageWidth();
        //get image height
        $imageHeight = $imageDPI->getImageHeight();
        //get image dpi
        $dpi = $imageDPI->getImageResolution();
        $horizontalDPI = $dpi['x'];
        $verticalDPI = $dpi['y'];

        $category     = Category::with('subcategory')
        ->where('id', $image->category_id)->first();
        // dd($category);
        $subcategory    = SubCategory::where('id', $image->sub_category_id)->first();
        // dd($subcategory);

        $categoryName   = '';


        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategoris = SubCategory::all();
        //if subcategory is empty then images of this category
        if($subcategoryId == null){
        $nextID         = Photo::where('category_id',$categoryId)->where('id', '>', $image_id)->min('id');
        // dd($nextID);
        $previousID      = Photo::where('category_id',$categoryId)->where('id', '<', $image_id)->max('id');
        // dd($image_id);
    }else{
        // dd($subcategoryId, $categoryId, $image_id);
         $nextID         = Photo::where('category_id',$categoryId)->where('sub_category_id',$subcategoryId)
         ->where('id', '>', $image_id)->min('id');
            // dd($nextID);
        $previousID      = Photo::where('category_id',$categoryId)->where('sub_category_id',$subcategoryId)
        ->where('id', '<', $image_id)->max('id');
        // dd($previousID);

        }




        return view('web.products.singleImage', compact('category', 'subcategory', 'categories' ,'image'
        ,'imageWidth' ,'imageHeight' ,'nextID' ,'previousID' ,'subcategoris', 'horizontalDPI', 'verticalDPI', 'subcategoryId', 'categoryId', 'categoryName'));
    }

    public function singleImage2(Request $request, $categoryId, $image_id)
    {
        // dd($subcategoryId);
        $image         = Photo::findorfail($image_id);
        //sorage path
        $public_path   = public_path() . '/images/photos/originalImage/' . $image->original_image;

        //getImageResolution from Imagick
        $imageDPI = new \Imagick($public_path);
        //get image width
        $imageWidth = $imageDPI->getImageWidth();
        // dd($imageWidth);
        //get image height
        $imageHeight = $imageDPI->getImageHeight();
        // dd($imageHeight);
        //get image dpi
        $dpi = $imageDPI->getImageResolution();
        $horizontalDPI = $dpi['x'];
        $verticalDPI = $dpi['y'];

        $categoryName   = '';


        $category     = Category::with('subcategory')
        ->where('id', $image->category_id)->first();
        // dd($category);
        $subcategory    = SubCategory::where('id', $image->sub_category_id)->first();
        // dd($subcategory);



        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();
        $subcategoris = SubCategory::all();
        //if subcategory is empty then images of this category
        $nextID         = Photo::where('category_id',$categoryId)->where('id', '>', $image_id)->min('id');
        // dd($nextID);
        $previousID      = Photo::where('category_id',$categoryId)->where('id', '<', $image_id)->max('id');
        // dd($image_id);





        return view('web.products.singleImage2', compact('category', 'subcategory', 'categories' ,'image'
        ,'imageWidth' ,'imageHeight' ,'nextID' ,'previousID' ,'subcategoris', 'horizontalDPI', 'verticalDPI', 'categoryId', 'categoryName'));
    }

    public function pagesAbout()

    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.about', compact('categories', 'subcategory'));
    }
    public function pagesContact()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.contact', compact('categories', 'subcategory'));
    }
    public function pagesCopyright()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.copyright', compact('categories', 'subcategory'));
    }
    public function pagesLisence()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.lisence', compact('categories', 'subcategory'));
    }
    public function pagesPrivacy()
    {
        $categories = Category::with('subcategory')->orderBy('sort', 'asc')->get();

        $subcategory = SubCategory::all();
        return view('web.products.privacy', compact('categories', 'subcategory'));
    }
}
