<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\Otpsend;
use App\Mail\ResetCustomerPassword;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerVerificationCode;
use App\Notifications\CustomerResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Category;
use App\SubCategory;


class AuthController extends Controller
{

    public function reset_password_request_form()
    {
        if(\auth()->guard('customer')->check()) return redirect()->route('home');
        $categories = Category::with('subcategory')->get();

        $subcategories = SubCategory::all();
        return view('auth.customer.password.email', compact('categories', 'subcategories'));
    }

    public function reset_password_request_validate(Request $request){
        $request->validate([
           'email' => ['required','email','exists:customers,email']
        ]);
        $customer = Customer::whereEmail($request->email)->first();
        DB::table('customer_password_resets')->insert([
                    'email' => $request->email,
                    'token' => lowerCaseAndDigits(60),
                    'created_at' => Carbon::now()->addMinutes(60)
                ]);

        $token = DB::table('customer_password_resets')
            ->where('email', $request->email)->orderBy('id', 'desc')->first();
        $emailHash = encrypt($request->email);
        /*Notification::send($customer, new CustomerResetPassword($token->token, $emailHash));*/
        $emailData['token'] = $token->token;
        $emailData['emailHash'] = $emailHash;
        Mail::to($customer->email)->send(new ResetCustomerPassword($emailData));
        return redirect()->back()->with('status', trans('Wir haben Ihnen ein E-Mail mit einem Link zum zur端cksetzen des Passwortes zugesandt.'));

    }

    public function reset_password_form($token, $email)
    {
        if(\auth()->guard('customer')->check()) return redirect()->route('home');
        $emailHash = $email;
        $email = decrypt($emailHash);
        $tokenData = DB::table('customer_password_resets')
            ->where(['email' => $email,'token' => $token ])->orderBy('id', 'desc')->first();
        if(!$tokenData){
            return redirect('404');
        }
        $nowDate = Carbon::now();
        if($nowDate->gt($tokenData->created_at)){
            return view('auth.customer.password.reset', compact('token', 'email', 'emailHash'))->with('expired', trans('Token ist abgelaufen, bitte setzen Sie das Passwort erneut zur端ck!'));
        }
        return view('auth.customer.password.reset', compact('token', 'email', 'emailHash'));
    }

    public function update_password(Request $request){
        $request->validate([
            'email' => ['required','email','exists:customers,email'],
            'token' => ['required','string'],
            'password' => ['required','string', 'min:8', 'confirmed'],
        ]);

        $customer = Customer::whereEmail($request->email)->first();
        $customer->update([
            'password' => Hash::make($request->password)
        ]);
        $cred['email'] = $request->email;
        $cred['password'] = $request->password;
        if (auth()->guard('customer')->attempt($cred)) {
            return redirect()->route('customer.dashboard');
        }
        return redirect()->route('customer.login_form');
    }

    public function verify_code($email){
        $emailText = decrypt($email);
        $user_code = CustomerVerificationCode::whereEmail($emailText)->orderBy('id', 'desc')->first();
        $nowDate = Carbon::now();
        if($nowDate->gt($user_code->expired_at)){
            $data['verification_error'] = __('auth.expired_verification_code');
            $data['email'] = $emailText;
            session()->forget($emailText);
            return view('auth.customer.verify_code', $data);
        }
        return view('auth.customer.verify_code', ['email' => $emailText]);
    }

    public function send_verification_code(Request $request) {
        // Validate ReCaptcha V2
        $recaptchaResponse = (new \ReCaptcha\ReCaptcha(config('recaptcha.api_secret_key')))
            ->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$recaptchaResponse->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => __('messages.google_recaptcha_failed')]);
        }
        $request->validate([
            'title' => ['required', 'string'  ],
            'name' => ['required', 'string' ],
            'last_name' => ['required', 'string' ],
            'email' => ['required', 'email', 'unique:customers',  'confirmed'],
        ]);
        $code = randomDigits(6);
        unset($request['g-recaptcha-response']);
        unset($request['_token']);
        /*$request['code'] = $code;*/
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['code'] = $code;
        $data['url'] = route('customer.verify_code', encrypt($request->email));
        $data['email_hash'] = Crypt::encrypt($request->email);

        Mail::to($request->email)->send(new Otpsend($data));
        CustomerVerificationCode::create([
            'email' => $request->email,
            'verification_code' => $code,
            'expired_at' => Carbon::now()->addMinute(10),
        ]);
        session([$request->email => $request->all()]);
        return redirect()->route('customer.verify_code', encrypt($request->email));
    }

    public function register(Request $request){
        $request->validate([
            'code' => ['required', 'string'],
            'agree' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $emailHash = encrypt($request->email);
        if(!$request->agree){
            $data['term_conditions'] = 'Bitte lesen und akzeptieren Sie die AGBs';
            $data['customer'] = $request->all();
            return redirect()->route('customer.verify_code', $emailHash)->with($data);
        }

        $user_code = CustomerVerificationCode::whereEmail($request->email)->orderBy('id', 'desc')->first();
        if(!$user_code){
            return redirect('404');
        }
        $nowDate = Carbon::now();
        if($nowDate->gt($user_code->expired_at)){
            /*$data['verification_error'] = __('auth.expired_verification_code');
            $data['customer'] = $request->all();
            return redirect()->route('customer.verify_code', $emailHash)->with($data);*/
            $data['customer'] = $request->all();
            return redirect()->back()
                ->withInput()
                ->withErrors(['code' => __('auth.expired_verification_code')])->with($data);
        }

        if($user_code->verification_code != $request->code){
            /*$data['verification_error'] = __('auth.verification_code_mismatch');
            $data['customer'] = $request->all();
            return redirect()->route('customer.verify_code',$emailHash)->with($data);*/
            $data['customer'] = $request->all();
            return redirect()->back()
                ->withInput()
                ->withErrors(['code' => __('auth.verification_code_mismatch')])->with($data);
        }
        $customer = Customer::create([
            'title' => $request->title,
            'first_name' =>$request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            /*'company' => $request->company,
            'road' => $request->road,
            'post_code' => $request->post_code,
            'place' => $request->place,
            'country' => $request->country,*/

        ]);
        $cred['email'] = $request->email;
        $cred['password'] = $request->password;
        if (auth()->guard('customer')->attempt($cred)) {

            $customer = Auth::guard('customer')->user();
            \Session::put('customer',  $customer);
            $request->session()->put('customer',  $customer);

            // dd($customer);
            session()->save();

            return redirect()->route('customer.dashboard');


        }
        return redirect()->route('customer.login_form');
    }

    public function logout(Request $request)
    {
        // $preferred_lang = session('locale');
        Auth::guard(Customer::$guardType)->logout();
        /*$request->session()->flush();*/
        $request->session()->regenerate();
        /*$request->session()->invalidate();*/
        // return redirect('/'.$preferred_lang);
        return redirect()->route('home');
    }

}
