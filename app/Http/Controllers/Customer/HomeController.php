<?php

namespace App\Http\Controllers\Customer;

use App\Helper\epp;
use App\Http\Controllers\Controller;
use App\Mail\Otpsend;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\Models\Customer\CustomerVerificationCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function dashboard(){
        $user_id = Auth::guard(Customer::$guardType)->id();
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30);

        $watchlist_planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
            $q->where('start_date', '>', $now)
                ->where('sold_at', null)->orderBy('sold_at', 'asc');
        })
            ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
            ->get()->count();


        $watchlist_active = CustomerAuction::whereHas('auction',function($q) use ($now) {
            $q->where('start_date', '<', $now)->where('sold_at', null)
                ->where('end_date', '>', $now)->orderBy('sold_at', 'asc');
        })
            ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
            ->get()->count();

        $watchlist_sold = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
            $q->where('sold_at', '!=', null)
                ->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
        })
            ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
            ->get()->take(10)->count();

        $watchlist_finished = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id, $now) {
                                                $q->where('sold_at',   null)
                                                    ->where('end_date', '>', $till_date)->where('end_date', '<', $now)->orderBy('end_date', 'asc');
                                            })
                                            ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                            ->get()->take(10)->count();

        $data['watchlist'] = $watchlist_planned + $watchlist_active + $watchlist_sold + $watchlist_finished;


        $favourite_planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
                $q->where('start_date', '>', $now)
                    ->where('sold_at', null);
            })
            ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
            ->get()->count();


        $favourite_active = CustomerAuction::whereHas('auction',function($q) use ($now) {
            $q->where('start_date', '<', $now)->where('sold_at', null)
                ->where('end_date', '>', $now);
        })
            ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
            ->get()->count();

        $favourite_sold = CustomerAuction::whereHas('auction',function($q) use ($now, $till_date) {
            $q->where('sold_at', '!=', null)->where('end_date', '<', $now)->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
        })
            ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
            ->get()->take(10)->count();

        $favourite_finished = CustomerAuction::whereHas('auction',function($q) use ($till_date, $now) {
            $q->where('sold_at',  null)->where('end_date', '<', $now)
                ->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
        })
            ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
            ->get()->take(10)->count();


        $data['favourite'] =$favourite_planned + $favourite_active + $favourite_sold + $favourite_finished ;

        $my_planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                            $q->where('start_date', '>', $now)
                                                ->where('sold_at', null);
                                        })
                                        ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                        ->get()->count();


        $my_active = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                    $q->where('start_date', '<', $now)->where('sold_at', null)
                                        ->where('end_date', '>', $now);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get()->count();

        $my_won = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
                                        $q->where('sold_to',   $user_id)
                                            ->where('created_at' ,'>',  $till_date)->orderBy('end_date', 'asc');
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get()->count();
                                    /*->get()->take(10)->count();*/

        $my_lost = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id, $now) {
                                    $q->where('sold_at', '!=', null)->where('sold_to','!=',   $user_id)
                                        ->where('created_at' ,'>',  $till_date)->orderBy('end_date', 'asc');
                                })
                                ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                ->get()->count();

         $data['my'] = $my_lost + $my_won + $my_active + $my_planned;


        return view('customer-portal.dashboard.index', $data);
    }


}
