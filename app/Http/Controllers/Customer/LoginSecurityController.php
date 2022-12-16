<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Models\Customer\CustomerLoginSecurity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;

class LoginSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $google2fa_url = "";
        $secret_key = "";

        if ($user->customer_login_security()->exists()) {
            $google2fa = (new Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                'Adomino.net',
                $user->email,
                $user->customer_login_security->google2fa_secret
            );
            $secret_key = $user->customer_login_security->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return view('customer-portal.2fa.2fa_settings')->with([
            'data' => $data,
            'sidebar' => '',
        ]);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret(Request $request)
    {
        $user = Auth::guard('customer')->user();
        // Initialise the 2FA class
        $google2fa = (new Google2FA());

        // Add the secret key to the registration data
        $login_security = CustomerLoginSecurity::firstOrNew(array('customer_id' => $user->id));
        $login_security->customer_id = $user->id;
        $login_security->google2fa_enable = 0;
        $login_security->google2fa_secret = $google2fa->generateSecretKey();
        $login_security->save();

        return redirect(route('customer.2fa-settings'))->with('success', __('auth.secret_key_generated'));
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $google2fa = (new Google2FA());

        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->customer_login_security->google2fa_secret, $secret);

        if ($valid) {
            $user->customer_login_security->google2fa_enable = 1;
            $user->customer_login_security->save();
            return redirect(route('customer.2fa-settings'))->with('success', __('auth.2fa_activate'));
        } else {
            return redirect(route('customer.2fa-settings'))->with('error', __('auth.invalid_confirmation_code'));
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::guard('customer')->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", __('auth.wrong_password'));
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::guard('customer')->user();
        $user->customer_login_security->google2fa_enable = 0;
        $user->customer_login_security->save();
        return redirect(route('customer.2fa-settings'))->with('success', __('auth.2fa_deactivate'));
    }

    public function customer_dashboard(){
        return redirect()->route('customer.dashboard');
    }

}
