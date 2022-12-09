<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
set_time_limit(0);
use App\Domain;
use App\Inquiry;
use App\Mail\GenralAuctionMail;
use App\Models\Admin\EmailTemplate;
use App\Models\Customer\AuctionEmailLog;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\Models\Customer\CustomerAuctionBid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\LandingpageInquiryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->return_array['class'] = 'container-fluid';
    }

    public function __invoke()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        return view('web.auction.auction-overview',  $this->return_array);
    }

    public function home()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        return view('web.home',  $this->return_array);
    }

    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        if(auth()->check()){
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }

    public function ablauf()
    {
        return view('web.auction.ablauf');
    }

    public function auction_details(Request $request, $type)
    {
        $user = Auth::guard(Customer::$guardType)->user();

        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        if ($request->ajax()) {
            $status = Auction::auction_type($type);
            $now = Carbon::now()->format('Y-m-d H:i:s');
            if($type == 'planned'){
                $auctions = Auction::where('start_date', '>', $now)->where('sold_at', null)/*->orderBy('start_date', 'asc')*/->get();
            }
            if($type == 'active'){
                $auctions = Auction::where('start_date', '<', $now)->where('end_date', '>', $now)->where('sold_at', null)/*->orderBy('end_date', 'asc')*/->get();
            }
            if($type == 'finished'){
                //$auctions = Auction::where('end_date', '<', $now)->where('created_at', '>', $till_date)/*->orderBy('end_date', 'asc')*/->get();
                $auctions = Auction::where('end_date', '<', $now)->where('created_at', '>', $till_date)->get();
            }
            return app('datatables')->collection($auctions)
                ->addIndexColumn()
                ->editColumn('domain', function ($auction) {
                    return '<td class="sorting_1">
                                <a class="domain text-dark" href="'.route('landingpage.domain', Crypt::encryptString($auction->domain)).'"><span>' . $auction->domain . '</span></a>
                            </td>';
                })
                ->editColumn('start_date', function ($auction) {
                    return '<td class="sorting_1" data-order="'.date('Y.m.d H:i', strtotime($auction->start_date)).'" > ' .date('d.m.Y H:i', strtotime($auction->start_date))  . '  </td>';
                })
                ->editColumn('end_date', function ($auction) {
                    return '<td class="sorting_1" data-order="'.date('Y.m.d H:i', strtotime($auction->end_date)).'"> ' . date('d.m.Y H:i', strtotime($auction->end_date))   . ' </td>';
                })
                ->editColumn('start_price', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->start_price.'">' . number_format($auction->start_price, 0 , ',', '.') . '</td>';
                })

                ->addColumn('actual', function ($auction) use ($type) {
                    if($type == 'planned' || $type == 'finished'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $actual_price = $auction->actual_price();
                    if (is_numeric($actual_price)) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> '.number_format($actual_price, 0, ',', '.').'</td>';
                    }
                    return '<td class="sorting_1"> '.$actual_price.' </td>';


                })
                ->addColumn('discount', function ($auction) use ($type) {
                    if($type == 'planned'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $discount = $auction->discount();
                    /*if($discount == 0){
                        return '<td class="sorting_1" data-order="'.$discount.'"> '.number_format($discount, 0, ',', '.').'% </td>';
                        return '<td class="sorting_1" data-order="'.$discount.'"> - </td>';
                    }*/
                    return '<td class="sorting_1" data-order="'.$discount.'"> '.number_format($discount, 0, ',', '.').'% </td>';


                })
                ->addColumn('remaining_time', function ($auction) use ($type) {

                    $closed = false;
                    $seconds = 0;
                    $start_date = Carbon::parse($auction->start_date);
                    $end_date = Carbon::parse($auction->end_date);
                    if($end_date->isPast()) $closed = true;
                    else $seconds = $auction->remaining_seconds($end_date);
                    if($type == 'planned'){
                        $seconds = $auction->remaining_seconds($start_date);
                        return '<td class="sorting_1"> - <span class="text-bold d-none'.($closed ? '': 'data-countdown').'" '.($closed ? '':'data-countdown="'.($auction->end_date).'"').' data-seconds="'.$seconds.'">'.($closed ? '-':'').'</span></td>';
                    }
                    if($type == 'finished'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    return '<td class="sorting_1">  <span class="text-bold '.($closed ? '': 'data-countdown').'" '.($closed ? '':'data-countdown="'.($auction->end_date).'"').' data-seconds="'.$seconds.'">'.($closed ? '-':'').'</span>  </td>';
                })
                ->addColumn('offer', function ($auction) use ($type) {
                    if($type == 'finished'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $end_date = Carbon::parse($auction->end_date);
                    if($end_date->isPast()) return '';
                    return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-success text-bold bid_manager"  data-id="'.$auction->id.'">Bietmanager</button> </td>';
                })
                ->editColumn('end_price', function ($auction) use ( $type) {
                    $class = '';
                    if($type == 'finished'){
                        /*$class = 'text-danger';*/
                        $class = 'text-success';
                    }
                    if($auction->sold_to){
                        $class = 'text-success';
                        $customer_auction = $auction->sold;
                        return '<td class="sorting_1"  data-order="'.$customer_auction->bid_price.'"> <span class="'.$class.'">' . number_format($customer_auction->bid_price, 0 , ',', '.') . '</span></td>';
                    }
                    if($type == 'planned' || $type == 'active' ){
                        $highest_bid = $auction->heighest_bid;
                        if($highest_bid){
                            return '<td class="sorting_1" data-order="'.$highest_bid->bid_price.'"><span >'.number_format($highest_bid->bid_price, 0 , ',', '.').'</span> </td>';
                        }
                    }
                    return '<td class="sorting_1"  data-order="'.$auction->end_price.'"> <span class="'.$class.'">' . number_format($auction->end_price, 0 , ',', '.') . '</span></td>';
                })
                ->addColumn('action', function ($auction)  use ($type){
                    $ids = [];
                    $closed = false;
                    $customer_auction_id = null;
                    $customer_auction_deleted_at = null;
                    if($type == 'finished') $closed = true;
                    $user = Auth::guard(Customer::$guardType)->user();
                    if($user){
                        $customer_auctions = CustomerAuction::where('customer_id', $user->id)->get('auction_id');
                        if($type == 'finished') {
                            $closed = true;
                            $customer_auctions = CustomerAuction::withTrashed()->where('customer_id', $user->id)->get('auction_id');
                        }
                        foreach ($customer_auctions as $customer_auction) $ids[] = $customer_auction->auction_id;

                        if(in_array($auction->id, $ids)){
                            $customer_auction = CustomerAuction::where([
                                'auction_id' => $auction->id,
                                'customer_id' => $user->id,
                                'status' => CustomerAuction::$watchlist
                            ])->first();

                            if($type == 'finished') {
                                $closed = true;
                                $customer_auction = CustomerAuction::withTrashed()->where([
                                    'auction_id' => $auction->id,
                                    'customer_id' => $user->id,
                                    'status' => CustomerAuction::$watchlist
                                ])->first();
                                if ($customer_auction) {
                                    $customer_auction_id = $customer_auction->id;
                                    $customer_auction_deleted_at = $customer_auction->deleted_at;
                                    if($customer_auction->trashed() and $closed){
                                        return '<a href="javascript:;" data-trashed="'.$customer_auction_deleted_at.'" data-id="'.$customer_auction_id.'" class="text-dark"  >-</a>';
                                    }
                                }
                            }
                            if ($customer_auction) {
                                $customer_auction_id = $customer_auction->id;
                                $customer_auction_deleted_at = $customer_auction->deleted_at;
                                return '<a href="javascript:;" class="remove_from_customer_auction" data-trashed="'.$customer_auction_deleted_at.'" ali data-id="'.$customer_auction_id.'" data-domain="'.$auction->domain.'"><i class="fas fa-bell text-primary font-medium my-1"></i></a>';
                            }


                        }
                        return '<a href="javascript:;" class="add_watchlist" onclick="add_watchlist('.$auction->id.', $(this))"  data-id="'.$auction->id.'" data-domain="'.$auction->domain.'"><i class="far fa-bell text-primary font-medium my-1"></i></a>';


                    }else{
                        if($type != 'finished') return '<a href="javascript:;" class="add_watchlist" onclick="add_watchlist('.$auction->id.')"  data-id="'.$auction->id.'" data-domain="'.$auction->domain.'"><i class="far fa-bell text-primary font-medium my-1"></i></a>';
                    }

                })
                ->rawColumns(['domain', 'start_date','end_date','start_price',  'actual', 'offer','discount', 'end_price', 'remaining_time',  'action'])
                ->make(true);

        }
        $this->return_array['type'] = $type;
        return view('web.auction.auction', $this->return_array);
    }

    public function auction_domain_detail($domain_hash) {
        $domainName = idn_to_utf8(Crypt::decryptString($domain_hash), IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        return $domainName;
       /* $domain = decrypt($domain_hash);
        $auction = Auction::whereDomain($domain)->first();
        $start_date = Carbon::parse($auction->start_date);
        $now = Carbon::now();
        $total_remaining = $start_date->diffInDays($now);
        $next_date = $start_date->addDay($total_remaining +1)->format('Y-m-d H:i');
        $remaining_seconds = $auction->remaining_seconds($next_date);
        $this->return_array['class'] = 'container-sm';
        $this->return_array['remaining_seconds'] = $remaining_seconds;
        $this->return_array['next_date'] = $next_date;
        $this->return_array['auction'] = $auction;
        return view('web.auction.auction-domain', $this->return_array);*/
    }

    public function clock($type){
        $time = Carbon::now()->format('H:i:s');
        if($type == 'admin') $time = Carbon::now()->format('H:i');
        return response()->json([
           'time' => $time ,
           'date' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function access_grant(Request $request)
    {
        if($request->post()){
            if($request->password == env('ACCESS_PASSWORD')){
                session(['locked_status' => 'unlock']);
                return redirect()->route('home');
            }
            return redirect()->back()->withErrors(['password' => 'Access password is wrong, Please try again!']);
        }
        if (session()->get('locked_status'))  return redirect()->back();
         return view('auth.customer.request_access');
    }
    public function bid_manager_automation()
    {
        return true;
        Artisan::call('bid_manager_auction_closing');
    }
    public function auction_automation()
    {
        echo 'auction_automation</br>';
        $this::auction_sold();
        $this::auction_ended();
        $this::auction_started();
        $this::price_droped();
        Log::info('Bid Automation Ended '. Carbon::now()->format('d-m-Y H:i'));
    }

    public static function auction_sold(){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $min_date= Carbon::now()->subDays(62)->format('Y-m-d H:i:s');
        //Acution Sold
        $customer_auctions = CustomerAuctionBid::wherehas('auction',function($q) use ($min_date, $now) {
            $q->where('sold_at', null)
                ->where('end_date' , '>', $now)
                ->whereDate('created_at' , '>', $min_date)
            ;
        })
            ->where('bid_type', 'normal')
            ->groupBy('auction_id')
            ->get();

        foreach ($customer_auctions as $customer_auction){
            $auction = Auction::whereId($customer_auction->auction_id)->first();
            if($auction){
                $start_date = Carbon::parse($auction->start_date);
                $end_date = Carbon::parse($auction->end_date);
                $current_step_price = $auction->actual_price();
                $highest_bid = CustomerAuctionBid::where('auction_id', $customer_auction->auction_id)->orderBy('bid_price', 'desc')->first();
                $bid_price = $highest_bid->bid_price;
                echo 'foreach - ' . $auction->domain . ' -  '.$bid_price.' -  '.$current_step_price.'  </br>';
                if ($bid_price == $current_step_price) {
                    echo 'Price Equals  - ' . $auction->domain . ' -  '.$bid_price.' -  '.$current_step_price.'  </br>';
                    $auction->update([
                        'end_date' => Carbon::now(),
                        'sold_at' => Carbon::now(),
                        'status' => Auction::$sold,
                        'sold_to' => $highest_bid->customer_id,
                    ]);

                    $domain = Domain::where('domain',$auction->domain)->first();
                    $domain->update([
                        'landingpage_mode' => Domain::$auction_sold
                    ]);
                    $sold_to = Customer::find($highest_bid->customer_id);

                    Auction::sold_to_customer_email($auction->domain, $sold_to->email, 'normal', $bid_price);
                    Auction::marked_favourite_email($customer_auction->auction_id, $auction, $sold_to);
                    Auction::bidded_email($customer_auction->auction_id, $auction, $sold_to);
                    Auction::watchlist_email($customer_auction->auction_id, $auction, $sold_to);

                }

            }
        }
    }

    public static function auction_ended(){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $min_date= Carbon::now()->subDays(62)->format('Y-m-d H:i:s');
        //Auction Ended
        $ended_auctions = Auction::wherehas('domain',function($q)  {
            $q->whereIn('landingpage_mode', [Domain::$auction_soon,Domain::$auction_active]) ;
        })->where('end_date', '<', $now)
            ->where('sold_to', null)
            ->where('closed', 0)
            ->orderBy('end_date', 'asc')
            ->whereDate('created_at' , '>', $min_date)
            ->get();

        foreach ($ended_auctions as $auction){
            if($auction->closed == 0) {
                $auction->update([
                    'closed' => 1,
                ]);
                $start_date = Carbon::parse($auction->start_date);
                $end_date = Carbon::parse($auction->end_date);
                if($end_date->isPast() && $auction->sold_at == null){
                    $domain = Domain::where('domain',$auction->domain)->first();
                    if($domain->landingpage_mode === Domain::$auction_active){
                        $domain->update([
                            'landingpage_mode' => Domain::$auction_ended
                        ]);
                        Auction::auction_ended_without_bid_email($auction);
                    }
                }
            }

        }
    }

    public static function auction_started(){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $min_date= Carbon::now()->subMinutes(2)->format('Y-m-d H:i:s');
        //Auction Started
        $active_auctions = Auction::where('start_date', '<', $min_date)->where('end_date', '>', $now)->where('sold_to', null)->where('started', false)->get();
        foreach ($active_auctions as $auction){

            $start_date = $auction->start_date;
            if(Carbon::parse($start_date)->isPast()){

                if($auction->started === 0){

                    $watchlist_customers = CustomerAuction::where(['auction_id' => $auction->id, 'status' => CustomerAuction::$watchlist])->get();
                    foreach ($watchlist_customers as $watchlist_customer){

                        $customer = Customer::find($watchlist_customer->customer_id);
                        //Email template added by Irtaza 03-03-2022
                        $gender = 'Sehr geehrter Herr';
                        $name = $gender . ' ' . $customer->last_name;
                        if($customer->title === 'mrs')  {
                            $gender = 'Sehr geehrte Frau ';
                            $name = $gender . ' ' . $customer->last_name;
                        }
                        $emailTemplate = EmailTemplate::find(18);
                        $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
                        $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain, $name] , $emailTemplate->email_text);
                        $data['regards'] = 'Ihr Adomino.net Team';

                        Mail::to($customer->email)->send(new GenralAuctionMail($data));


                        // $message = 'Die Auktion für die Domain '.$auction->domain.' wurde gestartet. Bitte beachten Sie, dass die Auktion auch vorzeitig enden kann, sobald ein Bieter die Domain sofort kauft. In diesem Fall wird die Auktion sofort beendet. Wenn Sie keine weiteren Watchlist-E-Mails für diese Domain erhalten möchten, können Sie die Domain in adomino.net von Ihrer Watchlist entfernen.';
                        // $data['subject'] = 'Adomino.net: Watchlist: Start der Auktion für die Domain '. $auction->domain;
                        // $data['message'] = $message;
                        // $data['regards'] = 'Ihr Adomino.net Team';
                        // Mail::to($customer->email)->send(new GenralAuctionMail($data));
                    }
                    $auction->update([
                        'started' => 1,
                    ]);
                }
            }

        }
    }

    public static function price_droped(){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $min_date= Carbon::now()->subDays(62)->format('Y-m-d H:i:s');
        // Price Droped
        $watchlist_auctions = CustomerAuction::wherehas('auction',function($q) use ( $now) {
            $q->where('sold_at', null)
                ->where('end_date' , '>', $now) ;
        })
            ->where('status', CustomerAuction::$watchlist)
            ->groupBy('auction_id')
            ->get();

        foreach ($watchlist_auctions as $watchlist_auction){

            $auction = $watchlist_auction->auction ;
            $average = $auction->average_per_day;
            $start_date = $auction->start_date;
            $new_start_date = Carbon::parse($start_date)->addDays(1);
            if($new_start_date->isPast()){

                $current_step_price = $auction->actual_price();
                $already_mail_sent = AuctionEmailLog::where(['auction_id' => $auction->id, 'current_auction_price' => $current_step_price])->get();
                if(count($already_mail_sent) === 0){

                    $watchlist_customers = CustomerAuction::where(['auction_id' => $auction->id, 'status' => CustomerAuction::$watchlist])->get();
                    foreach ($watchlist_customers as $watchlist_customer){
                        /* echo $watchlist_auction->id .' - '. $watchlist_auction->status .' - '. $watchlist_customer->id . ' ali</br>';*/

                        $customer = Customer::find($watchlist_customer->customer_id);
                        echo $watchlist_auction->id .' - '. $watchlist_auction->status .' - '. $watchlist_customer->id.' - '. $auction->domain .' - '. $customer->email . '</br>';
                        $emailTemplate = EmailTemplate::find(12);
                        $gender = 'Sehr geehrter Herr';
                        $name = $gender . ' ' . $customer->last_name;
                        if($customer->title === 'mrs')  {
                            $gender = 'Sehr geehrte Frau ';
                            $name = $gender . ' ' . $customer->last_name;

                        }
                        $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
                         $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]', '[[aktueller-preis]]', '[[neuer-preis]]'] , [$auction->domain, $name, number_format($current_step_price + $average,0 , ',', '.') , number_format($current_step_price, 0 , ',', '.')] , $emailTemplate->email_text);
                        $data['regards'] = 'Ihr Adomino.net Team';
                        Mail::to($customer->email)->send(new GenralAuctionMail($data));
                    }
                    AuctionEmailLog::create(['auction_id' => $auction->id, 'current_auction_price' => $current_step_price]);
                }
            }

        }
    }

    public function inqueries_import(){

        /*echo 'Import Old Inquries';
        exit();
        Inquiry::truncate();*/
        DB::beginTransaction();
        try {
            $new_inquries = inquries_old_data();
            $domains = [];
            foreach ($new_inquries as $index => $new_inqury){
                $domain = Domain::where('adomino_com_id',$new_inqury['domain_id'])->first();
                if($domain && $new_inqury['offer_price'] ) {
                    $name = explode(' ', trim($new_inqury['name']), 2);
                    $inqury = new Inquiry();
                    if ($new_inqury['email']) $inqury->email = $new_inqury['email'];
                    $inqury->prename = $name[0] ??  $name[1];
                    $inqury->surname = $name[1] ??  $name[0];
                    if ($new_inqury['ip']) $inqury->ip = $new_inqury['ip'];
                    if ($new_inqury['created_at']) $inqury->created_at = Carbon::parse($new_inqury['created_at']);
                    if ($new_inqury['offer_date']) $inqury->offer_time = Carbon::parse($new_inqury['offer_date']);
                    if ($new_inqury['domain_id']) $inqury->domain_id = $domain->id;
                    if ($new_inqury['offer_price']) $inqury->offer_price = $new_inqury['offer_price'];
                    $gender = 'i';
                    if ($new_inqury['gender'] == 'sgh' || $new_inqury['gender'] == 'm' || $new_inqury['gender'] == 'dmr') {
                        $gender = 'm';
                    }
                    if ($new_inqury['gender'] == 'sgf' || $new_inqury['gender'] == 'f' || $new_inqury['gender'] == 'dms') {
                        $gender = 'f';
                    }
                    $inqury->gender = $gender;
                    if ($new_inqury['website_language']) $inqury->website_language = $new_inqury['website_language'];
                    if ($new_inqury['browser_language']) $inqury->browser_language = $new_inqury['browser_language'];
                    $inqury->save() ;

                    echo '<br>';
                    echo 'ID  => ' . $inqury->id .' - Iteration => ' . $index;
                    echo '<br>';
                }else {
                    $domains[] = $new_inqury['domain_id'];
                }
            }
            DB::commit();
            return $domains;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }

    }

    public function new_offers()
    {

        return view('demo.one');
        /*Inquiry::truncate();
        $json = Storage::disk('local')->get('new_offers.json');
        $all = json_decode($json , true);

        foreach ($all['data'] as $index => $row){
            echo $index .'</br>';
            if (isset($row['name']) && $row['name'] != '-') {
                $name = explode(' ', trim($row['name']), 2);
                $prename = $name[0] ??  $name[1];
                $surname = $name[1] ??  $name[0];
            }else {
                $prename = explode('@', trim($row['email']))[0];
                $surname = explode('@', trim($row['email']))[0];
            }
            if (isset($row['domain'])){
                $domainName = parse_url($row['domain']);
                if ($domainName['host'] != '-'){
                    $domainName = str_replace('www.', '', $domainName['host']);
                    $domain = Domain::whereDomain($domainName)->first();
                    if ($domain) {
                        $created_at = Carbon::parse(trim($row['date']))->format('Y-m-d H:i');
                        $data['prename'] = $prename;
                        $data['surname'] = $surname;
                        $data['email'] = trim($row['email']);
                        $data['domain_id'] = $domain->id;
                        $data['created_at']  = $row['date'];
                        $newInquery = Inquiry::create($data);
                        $newInquery->created_at = $created_at;
                        $newInquery->save();
                        //$data['created_at']  = $created_at;
                        echo $created_at . '</br>';
                    }
                }
            }
        }*/



    }
    public function send_offers()
    {
        return view('demo.two');
        /*$json = Storage::disk('local')->get('sent_offers.json');
        $All = json_decode($json , true);

        foreach ($All['data'] as $index => $row){

            if (isset($row['name']) && $row['name'] != '-') {
                $name = explode(' ', trim($row['name']), 2);
                $prename = $name[0] ??  $name[1];
                $surname = $name[1] ??  $name[0];
            }else {
                $prename = explode('@', trim($row['email']))[0];
                $surname = explode('@', trim($row['email']))[0];
            }


            $offer_price = str_replace('.', '', $row['price']);

            if (isset($row['domain'])){
                $domainName = parse_url($row['domain']);
                if ($domainName['host'] != '-'){
                    $domainName = str_replace('www.', '', $domainName['host']);
                    $domain = Domain::whereDomain($domainName)->first();

                    if ($domain) {
                        $created_at = Carbon::parse(trim($row['date']));
                        $data['prename'] = $prename;
                        $data['surname'] = $surname;
                        $data['email'] = trim($row['email']);
                        $data['domain_id'] = $domain->id;
                        $data['offer_price']  = $offer_price;
                        $newInquery = Inquiry::create($data);
                        //$data['created_at']  = $created_at;
                        $newInquery->created_at = $created_at;
                        $newInquery->save();
                        echo $created_at . '</br>';

                    }
                }
            }
        }*/
    }

    public function import_offers(){

    }
}
