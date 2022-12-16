<?php

namespace App\Models\Admin;

use App\Domain;
use App\Mail\GenralAuctionMail;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\Models\Customer\CustomerAuctionBid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Auction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'domain',
        'days',
        'start_price',
        'end_price',
        'auction_area',
        'average_per_day',
        'hired_for',
        'start_date',
        'end_date',
        'status',
        'closed',
        'started',
        'steps',
        'sold_to',
        'sold_at',
    ];
    protected $hidden = [
        'hired_for',
    ];
    public static $planned = 1;
    public static $active = 2;
    public static $sold = 3;
    public static $finished = 4;


    public static function status($index = null){

        $status = [
            1 => 'Geplant',
            2 => 'Aktiv',
            3 => 'Verkauft',
            4 => 'Beendet',
        ];

        if($index){
            return $status[$index];
        }
        return $status;

    }

    public static function auction_type($type): int {

        $status = [
            'planned' => 1,
            'active' => 2,
            'sold' => 3,
            'finished' => 4,
        ];

        return $status[$type];
    }

    public static function calculate_increment($actual_average){
        $actual_average_length = strlen($actual_average);

        switch ($actual_average_length) {
            case 3:
                $average_increment = 5;
                break;
            case 4:
                $average_increment = 50;
                break;
            case 5:
                $average_increment = 500;
                break;
            case 6:
                $average_increment = 5000;
                break;
            default:
                $average_increment = 5;
        }

        return $average_increment;

    }

    public static function calculate_actual_average($int_average){
        $actual_average_length = strlen($int_average);

        switch ($actual_average_length) {
            case 3:
                $divider = 10;
                break;
            case 4:
                $divider = 100;
                break;
            case 5:
                $divider = 1000;
                break;
            case 6:
                $divider = 10000;
                break;
            default:
                $divider = 10;
        }

        return round($int_average/$divider, 0) * $divider;

    }

    public function customer_auction_watchlist()
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        return $this->hasOne(CustomerAuction::class, 'auction_id', 'id')->where('status', CustomerAuction::$watchlist)->where('customer_id', $user_id);
    }
    public function customer_auction_favourites()
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        return $this->hasOne(CustomerAuction::class, 'auction_id', 'id')->where('status', CustomerAuction::$favourite)->where('customer_id', $user_id);
    }

    public function minimum_price(){
        $auction = $this;
        $days = $auction->days;
        $start_price = $auction->start_price;
        $average = $auction->average_per_day;
        return $start_price - ($average * ($days));
    }

    public function actual_price(){
        $auction = $this;
        $current_date = Carbon::now();
        $actual = 0;
        $end_date = Carbon::parse($auction->end_date);
        $start_date = Carbon::parse($auction->start_date);
        if($end_date->isPast()){
            return $actual;
        }

        if($start_date->isPast()){
            $days_interval = $start_date->diffInDays($current_date);
            $start_price = $auction->start_price;
            $average = $auction->average_per_day;
            $actual = $start_price - ($average * ($days_interval));
            self::domain_auction_mode_active($auction, Domain::$auction_active);
            return $actual;
        }
        return $actual;
    }

    public function discount(){
        $auction = $this;
        $discount = 0;
        $current_date = Carbon::now();
        $start_date = Carbon::parse($auction->start_date);
        $end_date = Carbon::parse($auction->end_date);
        $average = $auction->average_per_day;
        $start_price = $auction->start_price;
        $days = $auction->days;
        $auction_area = $auction->auction_area;

        if($auction->sold_to){
            $days_interval = $start_date->diffInDays($end_date);
            $customer_bid = $auction->sold;
            if ($auction_area > 0) {
                if($customer_bid && $customer_bid->bid_type === 'normal'){
                    $discount = (100 / $days) *  $days_interval;
                    $discount = round($discount, 0);
                    return $discount;
                }else {
                    $discount = (100 / $days) *  (($start_price - $auction->sold->bid_price)/$average);
                    $discount = round($discount, 0);
                    return $discount;
                }

            }else {
                return 100;
            }
            /*$customer_auction = $auction->sold;
            $discount = (($auction->start_price - $customer_auction->bid_price) / $auction->start_price) * 100;
            return $discount;*/
        }
        if($end_date->isPast() && $auction->sold_at == null){
            if ($days == 1) {
                return $discount;
            }
            return 100;
        }

        if($start_date->isPast()){
            $days_interval = $start_date->diffInDays($current_date);
            if ($auction_area > 0) {
                $discount = (($average *  ($days_interval))/ $auction_area * 100);
                $discount = round($discount, 0);
            }
            return $discount;
        }
        return $discount;
    }

    public function latest_price(){
        $auction = $this;
        $actual = 0;
        $current_date = Carbon::now();
        if ($auction->days > 1) {
            $current_date = Carbon::now()->addDay(1);
        }

        $start_date = Carbon::parse($auction->start_date);
        $end_date = Carbon::parse($auction->end_date);
        if($end_date->isPast()){
            $days_interval = $start_date->diffInDays($end_date);
            $start_price = $auction->start_price;
            $average = $auction->average_per_day;
            $actual = $start_price - ($average * ($days_interval));
            return $actual;
        }
        if($start_date->isPast()){
            $days_interval = $start_date->diffInDays($current_date);
            $start_price = $auction->start_price;
            $average = $auction->average_per_day;
            $actual = $start_price - ($average * ($days_interval));
            return $actual;
        }
        return $actual;
    }

    public function latest_discount(){
        $auction = $this;
        $discount = 0;
        $current_date = Carbon::now();
        if ($auction->days > 1) {
            $current_date = Carbon::now()->addDay(1);
        }

        $end_date = Carbon::parse($auction->end_date);
        if($end_date->isPast()){
            return $discount;
        }
        $start_date = Carbon::parse($auction->start_date);
        if($start_date->isPast()){
            $average = $auction->average_per_day;
            $days = $auction->days;
            $auction_area = $auction->auction_area;
            $days_interval = $start_date->diffInDays($current_date);
            if ($auction_area > 0) {
                /*$discount = (($auction->start_price - $auction->actual_price()) / $auction->start_price) * 100;*/
                $discount = (($average *  ($days_interval))/$auction_area * 100);
                $discount = round($discount, 0);
            }

            return $discount;
        }
        return $discount;
    }

    public function remaining_seconds($date){
        $now = Carbon::now();
        return $now->diffInSeconds($date);
    }

    public function current_status(){
        $auction = $this;
        $end_date = Carbon::parse($auction->end_date);
        if($end_date->isPast()){
            if($auction->status != Auction::$finished){
                $auction->status = Auction::$finished;
                $auction->save();
            }

        }
        $start_date = Carbon::parse($auction->start_date);
        if($start_date->isPast() && !$end_date->isPast()){
            if($auction->status != Auction::$active){
                $auction->status = Auction::$active;
                $auction->save();
            }


        }
        if($auction->sold_to){
            if($auction->status != Auction::$sold){
                $auction->status = Auction::$sold;
                $auction->save();
            }


        }
        return Auction::status($auction->status);
    }

    public static function domain_auction_mode_active($auction, $mode){
        $domain = Domain::whereDomain($auction->domain)->first();
        $domain->update([
            'landingpage_mode' => $mode
        ]);
    }

    public function calculate_bid_price_range($highest_bid_price = null){
        $user = Auth::guard(Customer::$guardType)->user();
        $current_user_level =  $user->current_level();
        $auction = $this;
        $start_date = Carbon::parse($auction->start_date);
        $days = $auction->days;
        $start_price = $auction->start_price;
        $average = $auction->average_per_day;
        $current_date = Carbon::now();
        $diffInDays = 0;
        if ($start_date->isPast()) {
            $diffInDays = $start_date->diffInDays($current_date);
        }
        $daysLeft = $days - $diffInDays;
        $instant_price = $start_date->isPast() ?  $auction->actual_price() : $auction->start_price;
        $prices = [];
        if ($days > 1) {
            for ($i = 1; $i < $daysLeft; $i++){
                $next_price = $start_price - ($average * ($diffInDays + $i));
                /*if ($highest_bid_price) {
                    if($next_price > $highest_bid_price) $prices[] = $next_price;
                }else {
                    $prices[] = $next_price;
                }*/
                if($current_user_level === 4){
                    $prices[] = $next_price;
                }if($current_user_level === 3){
                    if($next_price <= 10000){
                        $prices[] = $next_price;
                    }
                }else if($current_user_level === 2){
                    if($next_price <= 1000){
                        $prices[] = $next_price;
                    }

                }
                /*$prices[] = $next_price;*/
            }
        }

        return $prices;
    }

    public function all_step_prices(){
        $auction = $this;
        $days = $auction->days;
        $start_price = $auction->start_price;
        $average = $auction->average_per_day;
        $prices = [];
        if ($days > 1) {
            for ($i = 0; $i < $days; $i++){
                $next_price = $start_price - ($average * ( $i));
                $prices[] = $next_price;
            }
        }else {
            $prices[] = $auction->start_price;
        }

        return $prices;
    }

    public function step_price(){
        $auction = $this;
        $start_price = $auction->start_price;
        $average = $auction->average_per_day;
        return $start_price - ($average * ($auction->days -1));

    }

    public function bids(){
        return $this->hasMany(CustomerAuctionBid::class, 'auction_id', 'id');
    }

    public function heighest_bid(){
        return $this->hasOne(CustomerAuctionBid::class, 'auction_id', 'id')->orderBy('bid_price', 'desc');
    }

    public function domain(){
        return $this->belongsTo(Domain::class, 'domain', 'domain');
    }

    public function normal_auction_mark_sold($end_date, $user_id){
        $auction = $this;
        if(!$auction->sold_to){
            $current_step_price = $auction->actual_price();
            $highest_bid = CustomerAuctionBid::where('auction_id', $auction->id)->orderBy('bid_price', 'desc')->first();
            $bid_price = $highest_bid->bid_price;

            if ($bid_price === $current_step_price) {
                echo $auction->domain . '</br>';
                $auction->update([
                    'end_date' => $end_date,
                    'sold_at' => $end_date,
                    'status' => Auction::$sold,
                    'sold_to' => $user_id,
                ]);
                $domain = Domain::where('domain',$auction->domain)->first();
                $domain->update([
                    'landingpage_mode' => Domain::$auction_sold
                ]);
                $sold_to = Customer::find($user_id);

                Auction::sold_to_customer_email($auction->domain, $sold_to->email, 'normal', $bid_price, $sold_to);
               /* Auction::marked_favourite_email($auction->id, $auction, $sold_to);*/
                Auction::bidded_email($auction->id, $auction, $sold_to);
                Auction::watchlist_email($auction->id, $auction, $sold_to);

            }
        }
    }

    public function sold(){
        return $this->hasOne(CustomerAuctionBid::class, 'auction_id', 'id')->where('customer_id', $this->sold_to)->orderBy('bid_price', 'desc');
    }

    public static function sold_to_customer_email($domain , $email, $type, $bid_price, $customer){
        if ($type == 'normal') {
            /*$data['subject'] = ' Adomino.net: Ihr Kauf der Domain '. $domain;
            $data['message'] = 'Wir beglückwünschen Sie zum Kauf der Domain '.$domain.' zum Preis von '.number_format($bid_price, 0 , ',', '.').' EUR (netto). Sie werden von uns ein gesondertes E-Mail mit der Rechnung und weiteren Instruktionen über den Transfer erhalten.';
            $data['regards'] = 'Ihr Adomino.net Team';*/
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $emailTemplate = EmailTemplate::find(8);
            $data['subject'] = str_replace(['[[domain]]'] , [$domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]', '[[vkpreis]]'] , [$domain, $name,  number_format($bid_price, 0, ',', '.')] , $emailTemplate->email_text);
            $emailSent = Mail::to($email)->bcc(env('ADMIN_EMAIL'))->send(new GenralAuctionMail($data));
            Mail::to($email)->bcc(env('ADMIN_EMAIL'))->send(new GenralAuctionMail($data));
        }elseif($type == 'immediately') {
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $emailTemplate = EmailTemplate::find(8);
            $data['subject'] = str_replace(['[[domain]]'] , [$domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]', '[[vkpreis]]'] , [$domain, $name,  number_format($bid_price, 0, ',', '.')] , $emailTemplate->email_text);
            $emailSent = Mail::to($email)->bcc(env('ADMIN_EMAIL'))->send(new GenralAuctionMail($data));
            /*$data['subject'] = 'Adomino.net: Ihr Kauf der Domain '. $domain;
            $data['message'] = 'Wir beglückwünschen Sie zum Kauf der Domain '. $domain.' zum Preis von '.number_format($bid_price, 0, ',', '.').' EUR (netto). Sie werden von uns ein gesondertes E-Mail mit der Rechnung und weiteren Instruktionen über den Transfer erhalten.';
            $data['regards'] = 'Ihr Adomino.net Team';
            $emailSent = Mail::to($email)->bcc(env('ADMIN_EMAIL'))->send(new GenralAuctionMail($data));*/
        }
    }

    public static function marked_favourite_email($id, $auction, $user){
        $favourits = CustomerAuction::where('auction_id', $id)->whereStatus(CustomerAuction::$favourite)->where('customer_id', '!=',$user->id)->get();
        foreach ($favourits as $favourit){
            $customer = Customer::find($favourit->customer_id);
            //Email template added by Irtaza 22-02-20222
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $emailTemplate = EmailTemplate::find(14);
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain, $name] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';

            Mail::to($customer->email)->send(new GenralAuctionMail($data));

            /*$data['subject'] = 'Adomino.net: Watchlist für die Domain  '. $auction->domain;
            $data['message'] = 'Ein Bieter hat die Domain '. $auction->domain.' gerade gekauft. Die Auktion ist somit beendet und Sie werden für die Domain keine weiteren Watchlist-E-Mails mehr erhalten.';
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));*/
        }
    }

    public static function bidding_email_to_watchlist($id, $auction, $user){
        $watchlist = CustomerAuction::where('auction_id', $id)->whereStatus(CustomerAuction::$watchlist)->where('customer_id', '!=',$user->id)->get();
        foreach ($watchlist as $row){
            $customer = Customer::find($row->customer_id);

            //Email template added by Irtaza 22-02-20222
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name; 
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $emailTemplate = EmailTemplate::find(15);
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain, $name] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));

            /*$data['subject'] = 'Adomino.net: Watchlist für die Domain  '. $auction->domain;
            $data['message'] = 'Ein Bieter hat für die Domain '. $auction->domain.' gerade ein Gebot abgegeben. Bitte beachten Sie, dass die Auktion auch vorzeitig beendet werden könnte, sobald ein Bieter die Domain sofort kauft. In diesem Fall wird die Auktion sofort beendet. Sofern Sie keine weiteren Watchlist-E-Mails für diese Domain erhalten wollen, können Sie die Domain in adomino.net aus Ihrer Watchlist wieder entfernen.';
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));*/
        }
    }

    public static function bidded_email($id, $auction, $user){
        $bidders = CustomerAuction::where('auction_id', $id)->whereStatus(CustomerAuction::$bided)->where('customer_id', '!=',$user->id)->get();
        foreach ($bidders as $bidder){
            $customer = Customer::find($bidder->customer_id);
            //Email template added by Irtaza 22-02-20222
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $emailTemplate = EmailTemplate::find(9);
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain, $name] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));
            /*$data['subject'] = 'Adomino.net: Ihr Gebot für die Domain '. $auction->domain;
            $data['message'] = 'Ein anderer Bieter hat die Domain '. $auction->domain. ' gerade gekauft. Es tut uns sehr leid, dass Sie für die Domain nicht Höchstbieter waren. Die Auktion ist somit beendet.';
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));*/
        }
    }

    public static function watchlist_email($id, $auction, $user){
        $bidders = CustomerAuction::where('auction_id', $id)->whereStatus(CustomerAuction::$watchlist)->where('customer_id', '!=',$user->id)->get();
        foreach ($bidders as $bidder){
            $customer = Customer::find($bidder->customer_id);
            /*$data['subject'] = 'Adomino.net: Watchlist für die Domain  '. $auction->domain;
            $data['message'] = 'Ein Bieter hat die Domain '. $auction->domain.' gerade gekauft. Die Auktion ist somit beendet und Sie werden für die Domain keine weiteren Watchlist-E-Mails mehr erhalten.';
            $data['regards'] = 'Ihr Adomino.net Team';*/

            $emailTemplate = EmailTemplate::find(14);
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain], $emailTemplate->email_subject);
            $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain , $name , ] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';

            Mail::to($customer->email)->send(new GenralAuctionMail($data));
        }
    }

    public static function auction_ended_without_bid_email($auction){
        $watchlist = CustomerAuction::where('auction_id', $auction->id)->whereStatus(CustomerAuction::$watchlist)->get();
        foreach ($watchlist as $watcher){
            $customer = Customer::find($watcher->customer_id);
            $emailTemplate = EmailTemplate::find(13);
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain], $emailTemplate->email_subject);
            $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]', '[[endpreis]]'] , [$auction->domain , $name , $auction->end_price ] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';
            Mail::to($customer->email)->send(new GenralAuctionMail($data));
        }
    }


}
