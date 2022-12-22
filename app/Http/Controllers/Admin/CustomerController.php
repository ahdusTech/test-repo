<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomerAccountRejected;
use App\Mail\CustomerDocumentApprovedEmail;
use App\Mail\CustomerDocumentApprovelEmail;
use App\Models\Customer\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Kunde';
    }
    public function index(Request $request)
    {
        $customers = null;
        if (isset($request->include_deleted) && $request->include_deleted == 'yes') {
            $customers = Customer::orderBy('id', 'desc')->withTrashed()->paginate(20);
        } elseif (isset($request->include_deleted) && $request->include_deleted == 'only_deleted') {
            $customers = Customer::orderBy('id', 'desc')->onlyTrashed()->paginate(20);
        } else{
            $customers = Customer::orderBy('id', 'desc')->paginate(20);
        }

        $sidebar = 'Kunde';
        return view('admin.auction.customers.index', compact('customers', 'sidebar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auction.customers.add')->with($this->return_array);
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
            'title' => ['required', 'string'  ],
            'first_name' => ['required', 'string' ],
            'last_name' => ['required', 'string' ],
            'email' => ['required', 'string', 'email' , 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'lang' => ['required', 'string'],
        ]);
        if ($request->password) {
            $request['password'] = Hash::make($request->password);
        }

        Customer::create($request->all());

        return redirect()->route('admin.customers')->with('message' ,  __('admin-customers.customer_profile_create'));
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
        $user = Customer::findOrFail($id);
        $this->return_array['user'] = $user;
        return view('admin.auction.customers.add')->with($this->return_array);
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

        // dd($request->all());
        $user = Customer::findOrFail($id);
        $request->validate([
            'title' => ['required', 'string'  ],
            'first_name' => ['required', 'string' ],
            'last_name' => ['required', 'string' ],
            'email' => ['required', 'string', 'email'],
            'password' => ['nullable', 'string', 'min:8'],
            'lang' => ['required', 'string'],
        ]);
        if ($request->password !== '') {
            $request['password'] = Hash::make($request->password);
        }else {
            unset($request['password']);
        }

        if ($request->email  == $user->email) {
            unset($request['email']);
        }else{
            $checkEmailExist = Customer::where([
                'email' => $request->email,
            ])->where('id', '!=' , $user->id)->get();
            if (count($checkEmailExist) > 0){
                return redirect()->back()->with('error' , __('customers-profile.email_exist'));
            }
        }
        $user->update($request->all());

        $customer = Customer::findOrFail($id);
        \Session::put('customer',  $customer);
        session()->save();

        // if($user->account_approved){
        //     Mail::to($user->email)->send(new CustomerDocumentApprovedEmail());
        // }else{
        //     $user->update([
        //         'verification_document' => null
        //     ]);
        //     Mail::to($user->email)->send(new CustomerAccountRejected());
        // }
        return redirect()->back()->with('message' ,  __('admin-customers.customer_profile_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Customer $customer)
    {
        // dd($customer->id);
        $cust = Customer::where('id', $customer->id)->forceDelete();
        // $customer->delete();
        return redirect()->back()->with('message', __('admin-customers.deleteUserSuccessMessage'));
    }

    public function getDeleteCustomerModal(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-customers.deleteCustomerModalTitle');
        $return_array['id'] = $request->id;
        return (string)view('admin.auction.customers.delete-modal')->with($return_array);
    }


}
