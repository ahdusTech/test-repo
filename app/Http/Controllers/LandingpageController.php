<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Models\Admin\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\LandingpageInquiryRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewInquiry;
use App\NotFoundDomain;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Contracts\Encryption\DecryptException;

class LandingpageController extends Controller
{
    public function domain(Request $request, $hash)
    {
        // Decrypt the hash
        try {
            $domainName = idn_to_utf8(Crypt::decryptString($hash), IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        } catch (DecryptException $e) {
            abort(404);
        }

        if (empty($hash)) throw \Exception(__('hashed_domain_invalid'));

        $domain = Domain::where('domain', $domainName)->first();
        if (!$domain) {
            if ($domainName != config('app.ip')) {
                NotFoundDomain::create(['domain' => $domainName]);
            }

            abort(404, __('messages.domain_404', ['domain' => $domainName]));
        }

        $auction = Auction::where('domain',$domainName)->first();
        if ($auction) {
            $start_date = Carbon::parse($auction->start_date);
            $end_date = Carbon::parse($auction->end_date);
            if($start_date->isPast() == 1 && !$end_date->isPast()){
                $domain->update([
                    'landingpage_mode' => Domain::$auction_active
                ]);
            }elseif ($start_date->isPast() == 0){
                $domain->update([
                    'landingpage_mode' => Domain::$auction_soon
                ]);
            }
            if($auction->sold_to){
                $domain->update([
                    'landingpage_mode' => Domain::$auction_ended
                ]);
            }
            if ($end_date->isPast()){
                if($auction->sold_to == null){
                    $domain->update([
                        'landingpage_mode' => Domain::$auction_ended
                    ]);
                }

                /*if($auction->sold){
                    $domain->update([
                        'landingpage_mode' => Domain::$auction_ended
                    ]);
                }else{
                    $domain->update([
                        'landingpage_mode' => Domain::$request_offer
                    ]);
                }*/
            }
            $now = Carbon::now();
            $total_remaining = $start_date->diffInDays($now);
            $next_date = $start_date->addDay($total_remaining + 1)->format('Y-m-d H:i');
            $remaining_seconds = $auction->remaining_seconds($next_date);
            if($auction->days == 1 or Carbon::parse($auction->end_date)->subDay(1)->isPast()){
                $next_date = Carbon::parse($auction->end_date);
                $remaining_seconds = $auction->remaining_seconds($next_date);
            }


        }

        $domain = Domain::where('domain', $domainName)->first();
        $domain->visits()->create([
            'ip' => $request->ip(),
        ]);
        $class = 'container-fluid';
        // Render landingpage
        if ($auction) {
            return view('landingpage.domain', compact('domain', 'auction','next_date','remaining_seconds', 'class'));

        }
        return view('landingpage.domain', compact('domain'));
    }

    public function send(LandingpageInquiryRequest $request)
    {

        // Validate ReCaptcha V2
        $recaptchaResponse = (new \ReCaptcha\ReCaptcha(config('recaptcha.api_secret_key')))
            ->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$recaptchaResponse->isSuccess()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => __('messages.google_recaptcha_failed')]);
        }

        $language = str_replace('_', '-', locale_accept_from_http($request->server('HTTP_ACCEPT_LANGUAGE')));

        $emails = explode(',', config('mail.admin'));

        $prename = ucwords(strtolower($request->prename));
        $surname = ucwords(strtolower($request->surname));

        $latin1_prename = iconv('UTF-8', 'ISO-8859-1', $prename);
        $latin1_surname = iconv('UTF-8', 'ISO-8859-1', $surname);

        $dateTime = date('Y-m-d H:i');
        $dateTimeWithTimezone = Carbon::now()->setTimezone('Europe/Vienna')->format('Y-m-d H:i');

        Mail::to($emails)
            ->send(new NewInquiry(
                $request->gender,
                $prename,
                $surname,
                $request->email,
                $request->domain,
                $request->ip(),
                $recaptchaResponse->getScore(),
                $language,
                $dateTime,
                LaravelLocalization::getCurrentLocale()
            ));

        $domain = Domain::where('domain', $request->domain)->firstOrFail();

        $domain->inquiries()->create([
            'gender' => $request->gender,
            'prename' => $prename,
            'surname' => $surname,
            'email' => $request->email,
            'ip' => $request->ip(),
            'website_language' => LaravelLocalization::getCurrentLocale(),
            'browser_language' => $language,
        ]);

        try {
            ssh_tunnel_call();

            $dvDomainsAngeboteId = DB::connection('adomino_com')
                ->table('dv_domains_angebote')
                ->insertGetId([
                    'domainid' => $domain->adomino_com_id,
                    'name' => $latin1_prename . ' ' . $latin1_surname,
                    'mail' => $request->email,
                    'ip' => $request->ip(),
                    'anrede' => $request->gender == 'f' ? 'sgf' : 'sgh',
                    'vorname' => $latin1_prename,
                    'nachname' => $latin1_surname,
                    'language' => LaravelLocalization::getCurrentLocale(),
                    'land' => $language,
                    'zeit' => $dateTimeWithTimezone,
                    'quelle' => 7,
                ]);

            DB::connection('adomino_com')
                ->table('dv_domains_angebote_aktionen')
                ->insert([
                    'angebotid' => $dvDomainsAngeboteId,
                    'aktionzeit' => $dateTimeWithTimezone,
                    'wer' => 0,
                    'aktionpreis' => 0,
                    'aktion' => ' ',
                    'umkopiert' => 0,
                ]);
        } catch (\Throwable $th) {
            Log::error('Error while send inquiry to adomino.com database.', [
                'exception' => $th,
            ]);

            Mail::to($emails)
                ->send(new NewInquiry(
                    $request->gender,
                    $prename,
                    $surname,
                    $request->email,
                    $request->domain,
                    $request->ip(),
                    $recaptchaResponse->getScore(),
                    $language,
                    date('Y-m-d H:i'),
                    LaravelLocalization::getCurrentLocale(),
                    'FEHLER - '
                ));
        }

        return view('static.success', [
            'gender' => $request->gender,
            'surname' => $request->surname,
            'domain' => $request->domain,
            'email' => $request->email
        ]);
    }
}
