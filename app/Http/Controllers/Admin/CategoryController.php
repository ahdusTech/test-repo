<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\User;
use Yajra\Datatables\Datatables;
use MichielKempen\NovaOrderField\OrderField;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Imagick;
use response;

class CategoryController extends Controller
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
    public function index()
    {
        // $categories = Category::all();
        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Kat-ID',
                'sort' => true,
            ),
            'status' => array(
                'name' => 'Aktiv?',
                'sort' => false,
            ),
            'image' => array(
                'name' => 'Bild',
                'sort' => false,
            ),
            'name' => array(
                'name' => 'Name',
                'sort' => true,
            ),
            'sort' => array(
                'name' => 'Sortierung',
                'sort' => true,
            ),
            'action' => array(
                'name' => 'Aktion',
                'sort' => false,
            ),
        );

        return view('admin.categories.index')->with($this->return_array);
    }

    public function sortLogo(Request $request)
    {
        $this->validate($request, [
            'mode' => 'required',
            'id' => 'required',
        ]);

        Category::sortLogo($request->mode, $request->id);
        return response()->json(['error' => 0, 'message' => 'done']);
    }

    public function deleteLogoProcessCat(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        Category::deleteLogo($request->id);
        return redirect()->back()->with('message', __('admin-logo.deleteLogoSuccessMessage'));
    }

    public function getDeleteLogoModalCat(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-logo.deleteLogoModalTitle');
        $return_array['id'] = $request->id;
        $category_name = Category::where('id', $return_array['id'])->value('name');
        $return_array['name'] = $category_name;

        return (string)view('logo-admin.delete-logo-modal')->with($return_array);
    }

    public function getAllCatJson()
    {
        $lastSorting = Category::getLastSortNumber();
        $firstSorting = Category::getFirstSortNumber();
        $all_scategories = Category::query()->orderBy('sort', 'asc')
        ->get();
            return Datatables::of($all_scategories)
                    ->addColumn('consecutive', function($row){
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->editColumn('id', function ($row) {
                        return '<p style="text-align: right;margin: 0px">' . $row->id . '</p>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 'active' ) {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                        } else {
                            return '<p style="text-align:center; line-height:0px; margin-bottom:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                        }
                    })
                    ->addColumn('image', function ($row) {
                        return '<div style="text-align:center; padding-left:7px;">
                        <img src="' . asset('/images/categories/'.$row->image) . '" style="object-fit: cover;width: 4rem; margin-top:5px; margin-bottom:3px;"/>
                        </div>';
                    })
                    ->editColumn('name', function($row){
                        return '<p style="margin: 0px">' . $row->name . '</p>';
                    })
                    ->editColumn('sort', function ($row) use ($lastSorting, $firstSorting) {
                        $arrowUp = "";
                        $arrowDown = "";
                        if ($row->sort != $firstSorting) {
                            $arrowUp = '<i data-url="' . route('sort-logo') . '" class="fas fa-arrow-circle-up sort" data-mode="up" data-sort="' . $row->sort . '" data-id="' . $row->id . '" style="font-size: 20px;cursor: pointer;"></i>&nbsp;&nbsp;';
                        }
                        if ($row->sort == $firstSorting) {
                            $arrowUp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
                        }
                        if ($row->sort != $lastSorting) {
                            $arrowDown = '<i data-url="' . route('sort-logo') . '" style="font-size: 20px;cursor: pointer;" data-mode="down" data-sort="' . $row->sort . '" data-id="' . $row->id . '" class="sort fas fa-arrow-circle-down"></i>';
                        }
                        return $arrowUp . $arrowDown;
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <a href="' . route('admin.edit.categories', [$row->id]) . '"
                        style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <label data-href="' . route('get-delete-logo-modal-cat') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    })
                    ->rawColumns([
                        'id',
                        'consecutive',
                        'status',
                        'image',
                        'name',
                        'sort',
                        'action',
                        ])
                    ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:12255'],
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->sort = (Category::getLastSortNumber() + 1);
        if($request->input('status') == 'on'){
            $category->status = 'active';
        } else {
            $category->status = 'inActive';
        }

         $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);


        if ($request->file('image')) {

        $uploadedoriginalImageresol = $request->file('image');
        $originalinputresolution = time().$uploadedoriginalImageresol->getClientOriginalName();
        $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath())->resize(510, 340);       // original image
        // $pathoriginalresolution = storage_path('/categories').'/'.$originalinputresolution;
        $pathoriginalresolution = public_path().'/images/categories/';
        $imgFileoriginalreso->save($pathoriginalresolution.$originalinputresolution);

        // $imgFileoriginalreso->save($pathoriginalresolution);

        // $imagick = new Imagick($pathoriginalresolution);

        // $imagick->setImageResolution(72,72) ; // it change only image density.

        // $saveImagePath = storage_path('/categories/72dpiImages') . '/' . $originalinputresolution;
        // $imagick->writeImages($saveImagePath, true);

        $category->image = $originalinputresolution;

          }
          $category->save();

        return redirect()->route('admin.categories')->with('message', 'category created successfully' );
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
        $category = Category::find($id);
        // dd($category);
        return view('admin.categories.edit', compact('category'));
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
            'name' => 'required',
        ]);

        $category = Category::findOrfail($request->id);
        $category->name = $request->name;
        $category->sort = $request->sort;

        if($request->input('status') == 'on'){
            $category->status = 'active';
        } else {
            $category->status = 'inActive';
        }

        if ($request->file('image')) {

            //find in public folder
            $image_path = public_path() . '/images/categories/' . $category->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            $uploadedoriginalImageresol = $request->file('image');
            $originalinputresolution = time().$uploadedoriginalImageresol->getClientOriginalName();
            $imgFileoriginalreso = Image::make($uploadedoriginalImageresol->getRealPath())->resize(510, 340);       // original image
            $pathoriginalresolution = public_path() . '/images/categories/';
            $imgFileoriginalreso->save($pathoriginalresolution . $originalinputresolution);

            // $imagick = new Imagick($pathoriginalresolution);

            // $imagick->setImageResolution(72,72) ; // it change only image density.

            // $saveImagePath = storage_path('app/public/categories/72dpiImages') . '/' . $originalinputresolution;
            // $imagick->writeImages($saveImagePath, true);

            $category->image = $originalinputresolution;


              }


          $category->update();

        return redirect()->route('admin.categories')->with('message', 'Category updated successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::find($id);
        $Category->delete();
        return redirect()->back()->with('message', 'Category deleted successfully' );
    }
}
