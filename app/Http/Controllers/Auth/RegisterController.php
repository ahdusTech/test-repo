<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Otpsend;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\SubCategory;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('guest:customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'road' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
            'place' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email', 'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return 'a;';
        $this->validator($data);
        $user = User::create([
            'title' => $data['name'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'company' => $data['company'],
            'road' => $data['road'],
            'post_code' => $data['post_code'],
            'place' => $data['place'],
            'country' => $data['country'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

        ]);
        $data['email_hash'] = Crypt::encrypt($data['email']);
        Mail::to($user->email)->send(new Otpsend($data));
        return $user;
    }

    public function showRegistrationForm() {
        return redirect()->route('customer.register_form');
    }

    public function showCustomerRegisterForm()
    {
        if(\auth()->guard('customer')->check()) return redirect()->back();
        $categories = Category::with('subcategory')->get();
        $subcategories = SubCategory::all();
        return view('auth.customer.customer_register', compact('categories', 'subcategories'));
    }


}
