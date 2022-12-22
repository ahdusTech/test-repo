<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomerDocumentApprovelEmail;
use App\Mail\Otpsend;
use App\Mail\ProfessionalEmailConfirmation;
use App\Models\Admin\Auction;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerVerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CertificateLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('customer-portal.auction.certificate');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $level)
    {
        $user = Auth::guard(Customer::$guardType)->user();
        if ($level == 2) {
            if($user->current_level() != 1) return redirect()->back();
            return view('customer-portal.auction.certificate_level.level2');
        }
        if ($level == 3) {
            if($user->current_level() != 2) return redirect()->back();
            return view('customer-portal.auction.certificate_level.level3');
        }
        if ($level == 4) {
            if($user->current_level() != 3) return redirect()->back();
            if($user->verification_document) return redirect()->back();
            return view('customer-portal.auction.certificate_level.level4');
        }
        return redirect('404');
    }

    public function email_confirmation_code(Request $request){
        $request->validate([
            'email' => ['required', 'email' ,'unique:customers,email' ],
        ]);
        $check_free_email = Customer::check_free_email($request->email);
        if($check_free_email){
            return  response()->json([
                'message' => 'Die von Ihnen angegebene E-Mail ist eine kostenlose E-Mail. Bitte verwenden Sie Ihre geschäftliche E-Mail, um fortzufahren..',
            ], 200);
        }
        $user = Auth::guard(Customer::$guardType)->user();
        $code = randomDigits(6);

        $data['code'] = $code;
        Mail::to($request->email)->send(new ProfessionalEmailConfirmation($data));
        CustomerVerificationCode::create([
            'email' => $user->email,
            'new_email' => $request->email,
            'verification_code' => $code,
            'expired_at' => Carbon::now()->addMinute(10),
        ]);
        return  response()->json([
            'message' => 'Der Verifizierungscode wurde an Ihre E-Mail gesendet.',
        ], 200);

    }
    public function update_business_details(Request $request){
        $validationRules = [
            'company' => ['nullable', 'string'],
            'road' => ['required', 'string'],
            'post_code' => ['required', 'string'],
            'country' => ['required', 'string'],
            'place' => ['required', 'string'],
            'tax_no' => ['nullable', 'string'],
            'terms' => ['required', 'boolean' ],
        ];

        $user = Auth::guard(Customer::$guardType)->user();
        if($user->is_free_email()){
            $validationRules['email'] = ['required', 'email'];
            $validationRules['pin_code'] = ['required', 'integer','min:6'];
            $request->validate($validationRules);
            $check_free_email = Customer::check_free_email($request->email);
            if($check_free_email){
                return  response()->json([
                    'message' => 'Die von Ihnen angegebene E-Mail ist eine kostenlose E-Mail. Bitte verwenden Sie Ihre geschäftliche E-Mail, um fortzufahren..',
                ], 200);
            }
            $user_code = CustomerVerificationCode::whereEmail($user->email)->where([
                'new_email' => $request->email,
            ])->orderBy('id', 'desc')->first();

            $nowDate = Carbon::now();
            if(!$user_code){
                return  response()->json([
                    'message' => 'Code kann nicht verifiziert werden. Bitte bestätigen Sie, dass der Code und die anderen Daten korrekt sind und versuchen Sie es erneut.',
                ], 400);
            }
            if($nowDate->gt($user_code->expired_at)){
                return  response()->json([
                    'message' =>  __('auth.expired_verification_code'),
                    'user_code' => $user_code,
                ], 400);
            }

            if($user_code->verification_code != $request->pin_code){
                return  response()->json([
                    'message' => __('auth.verification_code_mismatch'),
                ], 400);
            }
        }else {
            $request->validate($validationRules);
        }

        $user->update($request->all());
        return  response()->json([
            'message' => 'Ihre Unternehmensdaten wurden aktualisiert.',
        ], 200);

    }

    public function send_verification_code_sms(Request $request)
    {
        $request->validate([
           // 'phone_code' => ['required', 'string'  ],
            // 'phone_number' => ['required', 'string' ],

        ]);
        $user = Auth::guard(Customer::$guardType)->user();
        
        $code = randomDigits(6);
        $sms_text = 'Adomino.net: Ihr PIN-Code lautet: '.$code;
        $phone_code = str_replace('+', '', $request->phone_code);
        $phone = $phone_code.''.$request->phone_number;
        $send_sms = send_sms($phone, $sms_text, $request->phone_code);
        if($send_sms == '100'){
            CustomerVerificationCode::create([
                'email' => $user->email,
                'phone_code' => $phone_code,
                'phone_number' => $request->phone_number,
                'verification_code' => $code,
                'expired_at' => Carbon::now()->addMinute(10),
            ]);
            return  response()->json([
                'message' => 'Der Verifizierungscode wurde an Ihre Telefonnummer gesendet.',
                'send_sms' => $send_sms,
            ], 200);
        }else {
            return  response()->json([
                'message' => 'Überprüfungscode kann nicht gesendet werden! Bitte versuchen Sie Letzteres.',
                'sms_api' => $send_sms,
            ], 400);
        }
    }

    public function verify_mobile_number(Request $request){
        $request->validate([
            //'phone_code' => ['required', 'integer'  ],
            'phone_number' => ['required', 'integer' ],
            'pin_code' => ['required', 'integer' ],
            'terms' => ['required', 'boolean' ],
        ]);
        $user = Auth::guard(Customer::$guardType)->user();
        $phone_code = str_replace('+', '', $request->phone_code);
        $user_code = CustomerVerificationCode::whereEmail($user->email)->where([
                                                    'phone_code' => $phone_code,
                                                    'phone_number' => $request->phone_number,
                                                ])->orderBy('id', 'desc')->first();
        $nowDate = Carbon::now();
        if(!$user_code){
            return  response()->json([
                'message' => 'Code kann nicht verifiziert werden. Bitte bestätigen Sie, dass der Code und die anderen Daten korrekt sind und versuchen Sie es erneut.',
            ], 400);
        }
        if($nowDate->gt($user_code->expired_at)){
            return  response()->json([
                'message' =>  __('auth.expired_verification_code'),
                'user_code' => $user_code,
            ], 400);
        }

        if($user_code->verification_code != $request->pin_code){
            return  response()->json([
                'message' => __('auth.verification_code_mismatch'),
            ], 400);
        }


        $user->update([
            'phone_code' => $phone_code,
            'phone_number' => $request->phone_number,
            'phone_number_verified' => true,
        ]);

        return  response()->json([
            'message' => 'Ihre Rufnummer wurde überprüft.',
            'eng' => 'phone number has been verified',
        ], 200);
    }

    public function upload_document(Request $request){
        $request->validate([
            'document' => ['required', 'file', 'mimes:jpg,pdf', 'max:1024'],
            'terms' => ['required', 'boolean' ],
        ]);
        $user = Auth::guard(Customer::$guardType)->user();
        if ($request->file('document')) {
            $ext = $request->file('document')->extension();
            $name = $request->file('document')->getClientOriginalName();

           /* $filename = $request->file('document')->storeAs('public/upload/'.$user->id.'/document', $name . '.' . $ext);*/
            $filename = $request->file('document')->storeAs('public/upload/'.$user->id.'/document', $name );
            $user->update([
                'verification_document' => $filename
            ]);
            $data['id'] = $user->id;
            $data['url'] = route('admin.customer.edit', $user->id);
            Mail::to(env('ADMIN_EMAIL'))->send(new CustomerDocumentApprovelEmail($data));
            return  response()->json([
                'message' => 'Das Dokument wurde eingereicht.',
                'eng' => 'Document has been submited ',
            ], 200);
        }
    }
}
