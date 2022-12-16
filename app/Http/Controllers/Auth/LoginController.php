<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerLogin;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Category;
use App\SubCategory;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');
    }


    public function showLoginForm()
    {
        if(\auth()->guard('web')->check()) return redirect()->back();
        return view('auth.login');
    }
    public function showCustomerLoginForm()
    {
        if(\auth()->guard(Customer::$guardType)->check()) return redirect()->route('home');
        $categories = Category::with('subcategory')->get();
        $subcategories = SubCategory::all();
        return view('auth.customer.customer_login', compact('categories', 'subcategories'));
    }



    public function customerLogin(Request $request){
        $rules = array(
            'email'    => 'required|email|exists:customers',
            'password' => 'required||min:8'

        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::route('customer.login_form')->withErrors($validator);
        } else {
            $emailExist = Customer::where(['email' => $request->email])->first();
            if (!$emailExist){
                /*return Redirect::route('customer.login_form')->with('loginError', 'E-Mail nicht vorhanden!');*/
                return \redirect()->back()->withInput()->withErrors(['email' => 'E-Mail nicht vorhanden!']);
            }
            $userdata = array(
                'email'     => $request->email,
                'password'  => $request->password,
            );
            if (Auth::guard('customer')->attempt($userdata)) {
                CustomerLogin::create([
                    'customer_id' => Auth::guard(Customer::$guardType)->id(),
                    'last_login' => $_SERVER['REMOTE_ADDR'],
                ]);

            $customer = Auth::guard('customer')->user();

            // dd($customer);

                if(Auth::guard('customer')->user()->lang){
                    session(['customer' => Auth::guard(Customer::$guardType)->user()]);
                    session(['preferred_lang' => Auth::guard(Customer::$guardType)->user()->lang]);
                    session(['locale' => Auth::guard(Customer::$guardType)->user()->lang]);
                    App::setlocale(Auth::guard(Customer::$guardType)->user()->lang);
                    $url = LaravelLocalization::getLocalizedURL(session('locale'), route('customer.dashboard'));
                    // return redirect($url);
                }

                \Session::put('customer',  $customer);
                $request->session()->put('customer',  $customer);


                // $user = Auth::user();
                // dd($user);

                return redirect()->intended('/customer/dashboard');

                // dd(session()->all());

                // return redirect()->route('customer.dashboard');

            } else {
                /*return Redirect::route('customer.login_form')->with('loginError', 'Passwort falsch!');*/
                return \redirect()->back()->withInput()->withErrors(['password' => 'Passwort falsch!']);
            }
        }
    }

    protected function redirectTo() {
        /*if(Auth::guard(Customer::$guardType)->check()){
            return '/customer/dashboard';
        }if(Auth::guard('web')->check()){
            return '/admin';
        }else{
             return '/';
        }*/
        return '/admin';
    }

    /*public function checkLoggedUser() {
        if(Auth::user()->isAdmin()){
            return '/admin';
        }else{
            return '/user/dashboard';
        }
    }*/


}
