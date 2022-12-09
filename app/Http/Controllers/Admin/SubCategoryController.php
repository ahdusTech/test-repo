<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use response;
use Imagick;
use App\User;
use App\Category;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class SubCategoryController extends Controller
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
        // $subcategories = SubCategory::get();
        if ($category_name == null) {
            $categories = Category::all();
            // dd($categories);
        } else {
            $categories = Category::where('name','!=',$category_name)->get();
            // dd($categories);
        }

        // dd($category_name);
        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'consecutive' => array(
                'name' => '#',
                'sort' => false,
            ),
            'id' => array(
                'name' => 'Sub-ID',
                'sort' => true,
            ),
            'status' => array(
                'name' => 'Aktiv?',
                'sort' => false,
            ),
            'name' => array(
                'name' => 'Name',
                'sort' => false,
            ),
            'category_id' => array(
                'name' => 'Kategorie',
                'sort' => false,
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


        return view('admin.subcategories.index', compact('categories', 'category_name'))->with($this->return_array);
    }

    public function deleteLogoProcessSub(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        SubCategory::deleteLogo($request->id);
        return redirect()->back()->with('message', __('admin-logo.deleteLogoSuccessMessage'));
    }

    public function getDeleteLogoModaSub(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-logo.deleteLogoModalTitle');
        $return_array['id'] = $request->id;
        $subcategory_name = SubCategory::where('id', $return_array['id'])->value('name');
        $return_array['name'] = $subcategory_name;
        return (string)view('logo-admin.delete-logo-modal-sub')->with($return_array);
    }

    public function sortLogosub(Request $request)
    {
        $this->validate($request, [
            'mode' => 'required',
            'id' => 'required',
        ]);

        SubCategory::sortLogo($request->mode, $request->id);
        return response()->json(['error' => 0, 'message' => 'done']);
    }

    public function getAllSubCatJson(Request $request)
    {
        // if ($request->has('value')) {
        //     dd($request->has('value'));
        // }

        //category names of only the search value then take its id
        $category_id = Category::where('name', $request->search['value'])->value('id');

        // now take first sub cate of sort in category_id equals to first
        $firstSorting_sub_cat = SubCategory::where('category_id', $category_id)->orderBy('sort', 'asc')->first();

        // take first its sorting number
        if (!empty($firstSorting_sub_cat)) {
            $firstSorting = $firstSorting_sub_cat->sort;
        } else {
            $firstSorting = '';
        }


        // now take last sub cate of sort in category_id equals to first
         $lastSorting_sub_cat = SubCategory::where('category_id', $category_id)->orderBy('sort', 'desc')->first();

         // take last its sorting number
        if (!empty($lastSorting_sub_cat)) {

         $lastSorting = $lastSorting_sub_cat->sort;
        } else {
            $lastSorting = '';
        }

        //now query issues of data tables
        // jo searched kya uska category ka id
        $category_id_of_sub = Category::where('name', $request->search['value'])->value('id');

        $all_subcategories = SubCategory::query()->where('category_id', $category_id_of_sub)->orderBy('sort', 'asc')
        ->get();
        // dd($all_subcategories);


        if($request->ajax()){
                $category_name = $request->search['value'];
                // dd($DropDownSearchedCategory);
        }


            return Datatables::of($all_subcategories)
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
                    ->editColumn('name', function($row){
                        return '<p style="margin: 0px">' . $row->name . '</p>';
                    })
                    ->editColumn('category_id', function($row){
                        // return '';
                        return '<p style="margin: 0px">' . $row->Category->name . '</p>';
                    })
                    ->editColumn('sort', function ($row) use ($lastSorting, $firstSorting) {
                        $arrowUp = "";
                        $arrowDown = "";
                        if ($row->sort != $firstSorting) {
                            $arrowUp = '<i data-url="' . route('sort-logo-sub') . '" class="fas fa-arrow-circle-up sort" data-mode="up" data-sort="' . $row->sort . '" data-id="' . $row->id . '" style="font-size: 20px;cursor: pointer;"></i>&nbsp;&nbsp;';
                        }
                        if ($row->sort == $firstSorting) {
                            $arrowUp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
                        }
                        if ($row->sort != $lastSorting) {
                            $arrowDown = '<i data-url="' . route('sort-logo-sub') . '" style="font-size: 20px;cursor: pointer;" data-mode="down" data-sort="' . $row->sort . '" data-id="' . $row->id . '" class="sort fas fa-arrow-circle-down"></i>';
                        }
                        return $arrowUp . $arrowDown;
                    })
                    ->addColumn('action', function ($row) use ($category_name) {
                        return '
                        <a href="' . url('admin/edit/sub-categories', ['id' => $row->id, 'category_name' => $category_name ]) . '"
                        style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <label data-href="' . route('get-delete-logo-modal-sub') . '"
                        data-id="' . $row->id . '"
                        data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';

                    })
                    ->rawColumns([
                        'id',
                        'consecutive',
                        'status',
                        'name',
                        'category_id',
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
    public function getCatName(Request $request, $name)
    {
        $categories = DB::table('categories')->get()->pluck('name', 'id');

        return response()->json(['name' => $name]);

        // return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $name)
    {
        // dd($request);
        $category_name = $request->name;
        // dd($category_name);
        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;

        return view('admin.subcategories.create', compact('category_id', 'category_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'image'=>'required|image|mimes:jpeg,png,jpg,gif',
        //  ]);

        $image = new SubCategory();

        if($request->input('status') == 'on'){
            $image->status = 'active';
        }
        $image->sort = (SubCategory::getLastSortNumber() + 1);
        $image->name = $request->name;
        // $image->image_title = $request->image_title;
        $image->category_id = $request->category_id;



        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name = $categories->name;
        // dd($category_name);
        $image->save();

        //

        return redirect()->route('admin.subcategories', [$category_name])
        ->with('success','Unterkategorie hinzugefügt');

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
    public function edit(Request $request, $id, $category_name)
    {

        $categories = DB::table('categories')->where('name', $category_name)->first();
        $category_id = $categories->id;
        $category_name = $categories->name;
        // dd($category_name);
        $SubCategory = SubCategory::findOrfail($id);
        $categories = DB::table('categories')->get()->pluck('name', 'id');
        return view('admin.subcategories.edit', compact('SubCategory', 'category_id', 'category_name'));
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
        $image = SubCategory::find($request->id);
        $image->name = $request->name;
        if($request->input('status') == 'on'){
            $image->status = 'active';
        }
        $image->sort = $request->sort;
        // $image->image_title = $request->image_title;
        $image->category_id = $request->category_id;
        $categories = DB::table('categories')->where('id', $request->category_id)->first();
        $category_name = $categories->name;


          $image->update();

         return redirect()->route('admin.subcategories', [$category_name])
         ->with('UpdateSuccess', 'Unterkategorie erfolgreich aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = SubCategory::find($id);
        $Category->delete();
        return redirect()->back()->with('message', 'Sub Category deleted successfully' );
    }

}

