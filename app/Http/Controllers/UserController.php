<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Benutzer';
    }

    public function getFilterModal()
    {
        $return_array['ModalTitle'] = 'Filter User';
        return (string)view('users-admin.filter-modal')->with($return_array);
    }

    public function index()
    {
//        $this->return_array['page_length'] = -1;
//        $this->return_array['columns'] = array(
//            'consecutive_num' => array(
//                'name' => '#',
//                'sort' => false,
//            ),
//            'id' => array(
//                'name' => 'ID',
//                'sort' => true,
//            ),
//            'name' => array(
//                'name' => 'Name',
//                'sort' => true,
//            ),
//            'email' => array(
//                'name' => 'Email',
//                'sort' => true,
//            ),
//            'actions' => array(
//                'name' => __('admin-users.actionColumn'),
//                'sort' => false,
//            ),
//        );
        $this->return_array['users'] = User::get();
        return view('users-admin.index')->with($this->return_array);
    }

    public function addNewUserPage()
    {
        return view('users-admin.add')->with($this->return_array);
    }

    public function addNewUserProcess(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'position' => 'required|string',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        ]);
        $requesArray = $request->all();
        unset($requesArray['_token']);
        $requesArray['password'] = Hash::make($request->password);

        User::addUser($requesArray);
        return redirect()->back()->with('message', __('admin-users.addUserSuccessMessage'));
    }

    public function updateUserProcess(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name,' . $request->id,
            'email' => 'required|unique:users,email,' . $request->id,
            'position' => 'required|string',
        ]);
        $requesArray = $request->all();
        if (!empty($request->password)) {
            $this->validate($request, [
                'password' => 'required|min:6',
            ]);
            $requesArray['password'] = Hash::make($request->password);
        } else {
            unset($requesArray['password']);
        }
        unset($requesArray['_token']);
        unset($requesArray['id']);
        User::updateUser($requesArray, $request->id);
        return redirect()->back()->with('message', __('admin-users.updateUserSuccessMessage'));
    }

    public function getEditUserPage($id)
    {
        if (!is_numeric($id) || empty($id)) {
            dd('id not found');
        }
        $this->return_array['user'] = User::getUser($id);
        return view('users-admin.add')->with($this->return_array);
    }

    public function getDeleteUserModal(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-users.deleteUserModalTitle');
        $return_array['id'] = $request->id;
        return (string)view('users-admin.delete-modal')->with($return_array);
    }

    public function deleteUserProcess(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id_array = explode(',', $request->id);
        foreach ($id_array as $id) {
            User::deleteUser($id);
        }
        return redirect()->back()->with('message', __('admin-users.deleteUserSuccessMessage'));
    }

    public function getAllUsersJson()
    {
        $i = 0;
        return DataTables::of(User::query())
            ->addColumn('consecutive_num', function ($user) use ($i) {
                return $i;
            })
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('position', function ($user) {
                return $user->position;
            })
            ->addColumn('actions', function ($user) {
                return '<a href="' . route('get-edit-user-page', [$user->id]) . '" 
                style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                <label data-href="' . route('get-delete-user-modal') . '"  
                data-id="' . $user->id . '" 
                data-name="get-delete-user-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';
            })
            ->rawColumns([
                'id',
                'checkbox',
                'name',
                'email',
                'actions',
            ])->make(true);
    }


}
