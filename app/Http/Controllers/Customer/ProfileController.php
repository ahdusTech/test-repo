<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Auction;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer-portal.settings.profile');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Customer $customer)
    {
        $validationRules = [
            'password' => ['required', 'string','min:8'],
            'lang' => ['required', 'string'],
            'tax_no' => ['nullable', 'string'],
            'phone_code' => ['nullable', 'integer'],
            'phone_number' => ['nullable', 'integer','min:6'],
        ];
        if(!$customer->road){
            $validationRules['title'] =  ['required', 'string'];
            $validationRules['first_name'] =  ['required', 'string'];
            $validationRules['last_name'] =  ['required', 'string'];

        }
        if($customer->phone_number){
            $validationRules['company'] =  ['nullable', 'string'];
            $validationRules['road'] =  ['required', 'string'];
            $validationRules['post_code'] =  ['required', 'string'];
            $validationRules['country'] =  ['required', 'string'];
            $validationRules['place'] =  ['required', 'string'];
        }

        $request->validate($validationRules);

        if ($request->password) {
            $request['password'] = Hash::make($request->password);
        }

        $customer->update($request->all());
        session(['locale' => $request->lang]);
        $url = LaravelLocalization::getLocalizedURL(session('locale'), route('customer.profile'));

        return  response()->json([
            'message' => __('customers-profile.profile_update'),
            'url' => $url,
        ], 200);

        /*$url = null;
        if($current_lang != $request->lang){
            session(['locale' => $request->lang]);
            $url = LaravelLocalization::getLocalizedURL(session('locale'), route('customer.profile'));

        }*/
        /*return redirect($url)->with('message' ,  __('customers-profile.profile_update'));*/
        /*return redirect()->route('customer.profile')->with('message' ,  __('customers-profile.profile_update'));*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Customer $user)
    {
        if($request->post()) {
            $user->delete();
            Auth::guard(Customer::$guardType)->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->route('home');
        }
        $return_array['delete'] = true;
        $return_array['won'] = false;
        $return_array['bided'] = false;
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;

        $customer_won_auctions = CustomerAuction::whereHas('auction',function($q) use ($user_id) {
                                    $q->where('sold_to',   $user_id);
                                })
                                ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                ->get()->count();


        $now = Carbon::now()->format('Y-m-d H:i:s');
        $customer_bided_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('sold_at', null)->where('end_date', '>', $now);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get()->count();

        if($customer_bided_auctions > 0){
            $return_array['delete'] = false;
            $return_array['won'] = false;
            $return_array['bided'] = true;
        }else if($customer_won_auctions > 0){
            $return_array['delete'] = false;
            $return_array['bided'] = false;
            $return_array['won'] = true;
        }

        return view('customer-portal.settings.delete_account')->with($return_array);
    }
    /*public function destroy_alert(Request $request, Customer $user)
    {
        $user_id = $user->id;
        $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($user_id) {
                                $q->where('sold_to',   $user_id) ->orderBy('end_date', 'asc');
                            })
                            ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                            ->get();
        $return_array['ModalTitle'] = __('customers-sidebar.delete_account') ;
        $return_array['id'] = $user->id;
        return (string)view('customer-portal.settings.delete-modal')->with($return_array);
    }*/
}
