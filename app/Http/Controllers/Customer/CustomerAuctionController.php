<?php

namespace App\Http\Controllers\Customer;

use App\Domain;
use App\Http\Controllers\Controller;
use App\Mail\GenralAuctionMail;
use App\Mail\ProfessionalEmailConfirmation;
use App\Models\Admin\Auction;
use App\Models\Admin\EmailTemplate;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\Models\Customer\CustomerAuctionBid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CustomerAuctionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        if ($request->ajax()) {

           
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
                    /*$days = $auction->days;
                    $new_end_date = Carbon::parse($auction->start_date)->addDay($days);
                    return '<td class="sorting_1" data-order="'.$new_end_date->format('Y.m.d H:i').'"> ' . $new_end_date->format('d.m.Y H:i')  . ' </td>';*/
                    $end_date = Carbon::parse($auction->end_date);
                    $end_price = $auction->end_price;
                    $start_price = $auction->start_price;
                    $days = $auction->days;
                    $average_per_day = $auction->average_per_day;
                    if (!$auction->sold_to) {
                        $customer_bid = $auction->heighest_bid;
                        if($customer_bid){
                            $diff = 0;
                            if($average_per_day > 0){
                                $bid_price = $customer_bid->bid_price;
                               /* $diff = ($start_price - $bid_price) / $average_per_day;*/
                                /*$diff = (($bid_price - $end_price) / $average_per_day)  + 1*/;
                                $diff = (($start_price - $bid_price ) / $average_per_day);
                                $end_date = Carbon::parse($auction->start_date)->addDays($diff);
                            }

                        }
                    }
                    return '<td class="sorting_1" data-order="'.date('Y.m.d H:i', strtotime($end_date)).'"> ' . date('d.m.Y H:i', strtotime($end_date))   . ' </td>';
                })
                ->editColumn('start_price', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->start_price.'">' . number_format($auction->start_price, 0 , ',', '.') . '</td>';
                })
                ->editColumn('status', function ($auction) {
                    $status = $auction->current_status();
                    return '<td class="sorting_1" data-order="'.$auction->status.'">
                                <span>' . $status . '</span> 
                            </td>';
                })
                
                
                ->addColumn('remaining_time', function ($auction) use ($user_id) {
                    $closed = false;
                    $seconds = 0;
                    $start_date = Carbon::parse($auction->start_date);
                    $end_date = Carbon::parse($auction->end_date);
                    $end_price = $auction->end_price;
                    $start_price = $auction->start_price;
                    $average_per_day = $auction->average_per_day;
                    if($end_date->isPast()) $closed = true;
                    else $seconds = $auction->remaining_seconds($end_date);
                   

                    $customer_bid = $auction->heighest_bid;
                    if($customer_bid){
                        $bid_price = $customer_bid->bid_price;
                        /*$diff = (($bid_price - $end_price) / $average_per_day) + 1;
                        $end_date = Carbon::parse($auction->end_date)->subDays($diff);*/
                        $diff = (($start_price - $bid_price ) / $average_per_day);
                        $end_date = Carbon::parse($auction->start_date)->addDays($diff);
                        if($end_date->isPast()){
                            $seconds = 0;
                            $auction->normal_auction_mark_sold($end_date, $user_id);

                        }
                        else {
                            $seconds = $auction->remaining_seconds($end_date);
                        }
                        /*if ($bid_price == $end_price) {
                            $end_date = Carbon::parse($auction->end_date)->addDay(1);
                        }else {
                            $diff = (($bid_price - $end_price) / $average_per_day) + 1;
                            $end_date = Carbon::parse($auction->end_date)->subDays($diff);
                            if($end_date->isPast()){
                                $seconds = 0;
                                $auction->normal_auction_mark_sold($end_date, $user_id);

                            }
                            else {
                                $seconds = $auction->remaining_seconds($end_date);
                            }
                        }*/

                    }
                    return '<td class="sorting_1">  <span class="text-bold data-countdown" data-countdown="'.($end_date).'" data-seconds="'.$seconds.'"> </span>  </td>';
                })
                
                
                  
               
               
                ->rawColumns(['domain', 'status','start_date','end_date','start_price',  'actual', 'offer','discount', 'end_price', 'remaining_time',  'favourite',  'watch'])
                ->make(true);

        }


        $planned = Auction::where(function ($q) use ($now) {
            $q->where('start_date', '>', $now);
            $q->where('end_date', '>', $now);
        })->where('sold_to', null)->get()->count();

        $active = Auction::where('start_date', '<', $now)->where('end_date', '>', $now)->where('sold_to', null)->get()->count();

        $finished = Auction::where('end_date', '<', $now)->where('created_at', '>', $till_date)->get()->take(10)->count();

        
        $this->return_array['planned'] = $planned;
        $this->return_array['active'] = $active;
        $this->return_array['finished'] = $finished;
        return  view('customer-portal.auction.index', $this->return_array);
    }

    public function my_auctions(Request $request, $type)
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        if ($request->ajax()) {
            if($type == 'planned'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                                        $q->where('start_date', '>', $now)
                                                            ->where('sold_at', null);
                                                    })
                                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                                    ->get();

            }
            if($type == 'active'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('start_date', '<', $now)->where('sold_at', null)
                                            ->where('end_date', '>', $now);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get();
            }
            if($type == 'won'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
                                        $q->where('sold_to',   $user_id)->where('created_at', '>', $till_date);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get();
            }
            if($type == 'lost'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id, $now) {
                                        $q->where('sold_at', '!=', null)->where('sold_to','!=',   $user_id)->where('created_at', '>', $till_date);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get();
            }
            return app('datatables')->collection($customer_auctions)
                ->addIndexColumn()
                ->editColumn('domain', function ($auction) {
                    return '<td class="sorting_1">
                                <a class="domain text-dark" href="'.route('landingpage.domain', Crypt::encryptString($auction->auction->domain)).'"><span>' . $auction->auction->domain . '</span></a>
                            </td>';
                })
                ->editColumn('start_date', function ($auction) {
                    return '<td class="sorting_1" data-order="'.date('Y.m.d H:i', strtotime($auction->auction->start_date)).'" > ' .date('d.m.Y H:i', strtotime($auction->auction->start_date))  . '  </td>';
                })
                ->editColumn('end_date', function ($auction) use ($user_id) {
                    $end_date = Carbon::parse($auction->auction->end_date);
                    $end_price = $auction->auction->end_price;
                    $start_price = $auction->auction->start_price;
                    $days = $auction->auction->days;
                    $average_per_day = $auction->auction->average_per_day;
                    if (!$auction->auction->sold_to) {
                        $customer_bid = $auction->auction->heighest_bid;
                        if($customer_bid && $customer_bid->bid_type === 'normal'){
                            $diff = 0;
                            if($average_per_day > 0){
                                $bid_price = $customer_bid->bid_price;
                                /*$diff = ($bid_price - $end_price) / $average_per_day + 1;*/
                                $end_date = Carbon::parse($auction->auction->end_date)->subDay($diff);
                                $diff = (($start_price - $bid_price ) / $average_per_day);
                                $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);

                            }

                        }
                    }
                    return '<td class="sorting_1" data-order="'.date('Y.m.d H:i', strtotime($end_date)).'"> ' . date('d.m.Y H:i', strtotime($end_date))   . ' </td>';
                })
                ->editColumn('start_price', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->auction->start_price.'">' . number_format($auction->auction->start_price, 0 , ',', '.') . '</td>';
                })
                ->editColumn('bid_price', function ($auction) use ($type, $user_id) {
                    $class = 'text-danger';
                    /*$highest_bit = CustomerAuction::where(['auction_id' => $auction->auction_id , 'status' => CustomerAuction::$bided])->orderBy('bid_price', 'desc')->first();*/
                    /*$highest_bit = CustomerAuctionBid::where(['auction_id' => $auction->auction_id ])->orderBy('bid_price', 'desc')->first();*/
                    $highest_bit = $auction->auction->heighest_bid;
                    if($highest_bit && $highest_bit->customer_id == $user_id && $type != 'lost'){
                        $class = 'text-success';
                    }
                    if($type === 'won'){
                        $class = 'text-success';
                    }
                    if ($auction->customer_bid) {
                        return '<td class="sorting_1" data-order="'.($auction->customer_bid->bid_price) .'"><span class="'.$class.'">' . number_format($auction->customer_bid->bid_price, 0 , ',', '.') . '</span></td>';
                    }
                    return '<td class="sorting_1" >-</span></td>';

                })
                ->editColumn('days', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->auction->days.'">' .$auction->auction->days . '</td>';
                })
                ->editColumn('average_per_day', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->auction->average_per_day.'">' .number_format($auction->auction->average_per_day, 0 , ',', '.') . '</td>';
                })

                ->addColumn('actual', function ($auction) use ($type) {
                    if($type == 'planned' || $type == 'won'|| $type == 'lost'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $actual_price = $auction->auction->actual_price();
                    if ($actual_price == 0) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> - </td>';
                    }
                    if (is_numeric($actual_price)) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> '.number_format($actual_price, 0, ',', '.').'</td>';
                    }

                })
                ->addColumn('discount', function ($auction) use ($type) {
                    if($type == 'planned' && $auction->auction->sold_at == null){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $discount = $auction->auction->discount();
                    return '<td class="sorting_1" data-order="'.$discount.'"> '.$discount.'% </td>';
                    /*return '<td class="sorting_1" data-order="'.$discount.'"> '.number_format($discount, 0, ',', '.').'% </td>';*/


                })
                ->addColumn('remaining_time', function ($auction) use ($user_id, $type) {
                    if($type == 'planned' || $type == 'won' || $type == 'lost'){
                        return '<td class="sorting_1"> - </td>';
                    }
                    $closed = false;
                    $seconds = 0;
                    $start_date = Carbon::parse($auction->auction->start_date);
                    $end_date = Carbon::parse($auction->auction->end_date);
                    $start_price = $auction->auction->start_price;
                    $end_price = $auction->auction->end_price;
                    $days = $auction->auction->days;
                    $average_per_day = $auction->auction->average_per_day;
                    $seconds = $auction->auction->remaining_seconds($end_date);
                    $customer_bid = $auction->auction->heighest_bid;
                    if($customer_bid){
                        $bid_price = $customer_bid->bid_price;
                        /*$diff = (($bid_price - $end_price) / $average_per_day) + 1;
                        $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);*/
                        $diff = (($start_price - $bid_price ) / $average_per_day);
                        $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);
                        if($end_date->isPast()){
                            $seconds = 0;
                            $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                        }
                        else {
                            $seconds = $auction->auction->remaining_seconds($end_date);
                        }
                        /*if ($bid_price == $end_price) {
                            $end_date = Carbon::parse($auction->auction->end_date)->addDay(1);
                        }else {
                            $diff = (($bid_price - $end_price) / $average_per_day) + 1;
                            $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);
                            if($end_date->isPast()){
                                $seconds = 0;
                                $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                            }
                            else {
                                $seconds = $auction->auction->remaining_seconds($end_date);
                            }
                        }*/

                    }
                    return '<td class="sorting_1">  <span class="text-bold data-countdown" data-countdown="'.($end_date).'" data-seconds="'.$seconds.'"> </span>  </td>';
                })
                ->addColumn('offer', function ($auction) use ($type) {
                    if($type == 'won' || $type == 'lost'){
                        return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-primary text-bold bidder_list OpenModal" data-href="'.route('get-bidder-list-modal').'"   data-name="get-bidder-list"   data-id="'.$auction->auction->id.'"  data-type="'.$type.'">Bieter</button> </td>';
                    }
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) return '';
                    return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-success text-bold bid_manager"  data-id="'.$auction->auction->id.'">Bietmanager</button> </td>';
                })
                ->editColumn('end_price', function ($auction) use ($user_id, $type) {
                    $class = '';
                    if($type == 'lost'){
                        $class = 'text-danger';
                    }
                    if($auction->auction->sold_to){
                        /*$sold_to = CustomerAuction::where(['auction_id' => $auction->auction_id,'customer_id' => $auction->auction->sold_to, 'status' => CustomerAuction::$bided])->first();*/
                        $sold_to = $auction->auction->sold;
                        return '<td class="sorting_1" data-order="'.$sold_to->bid_price.'"> <span>' . number_format($sold_to->bid_price, 0 , ',', '.') . '</span></td>';
                    }

                    if($type == 'planned' || $type == 'active' ){
                        $highest_bid = $auction->auction->heighest_bid;
                        if($highest_bid){
                            if($highest_bid->customer_id == $user_id){
                                $class = 'text-success';
                            }else {
                                $class = 'text-danger';
                            }
                            return '<td class="sorting_1" data-order="'.$highest_bid->bid_price.'"><span >'.number_format($highest_bid->bid_price, 0 , ',', '.').'</span> </td>';
                        }
                    }
                    return '<td class="sorting_1"  data-order="'.$auction->auction->end_price.'"> <span class="'.$class.'">' . number_format($auction->auction->end_price, 0 , ',', '.') . '</span></td>';
                })
                ->rawColumns(['domain', 'start_date','end_date','start_price','average_per_day', 'days',  'actual','discount', 'remaining_time' ,'bid_price','end_price', 'offer'])
                ->make(true);

        }


        $planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('start_date', '>', $now)
                                            ->where('sold_at', null);
                                    })
                                    ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                    ->get()->count();


        $active = CustomerAuction::whereHas('auction',function($q) use ($now) {
            $q->where('start_date', '<', $now)->where('sold_at', null)
                ->where('end_date', '>', $now);
        })
            ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
            ->get()->count();

        $won = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
            $q->where('sold_to',   $user_id)->where('created_at', '>', $till_date);
        })
            ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
            ->get()->count();

        $lost = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id, $now) {
                                    $q->where('sold_at', '!=', null)->where('created_at', '>', $till_date)->where('sold_to','!=',   $user_id);
                                })
                                ->where(['status' => CustomerAuction::$bided, 'customer_id' => $user_id])
                                ->get()->count();

        $this->return_array['type'] = $type;
        $this->return_array['planned'] = $planned;
        $this->return_array['active'] = $active;
        $this->return_array['won'] = $won;
        $this->return_array['lost'] = $lost;

        return  view('customer-portal.auction.my', $this->return_array);

    }

    public function favourite(Request  $request, $type)
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        if ($request->ajax()) {
            $status = CustomerAuction::$favourite;
            if($type == 'planned'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                    $q->where('start_date', '>', $now)
                        ->where('sold_at', null)->orderBy('sold_at', 'asc');
                })
                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                    ->get();

            }
            if($type == 'active'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                    $q->where('start_date', '<', $now)->where('sold_at', null)
                        ->where('end_date', '>', $now)->orderBy('sold_at', 'asc');
                })
                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                    ->get();
            }
            if($type == 'sold'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
                    $q->where('sold_at', '!=', null)->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                })
                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                    ->get();
            }
            if($type == 'finish'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now, $user_id, $till_date) {
                    $q->where('end_date', '<', $now)->where('end_date', '>', $till_date)->where('sold_at',  null)->orderBy('end_date', 'asc');
                })
                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                    ->get();
            }

            /*$status = CustomerAuction::auction_status($type);*/

            /*$customer_auctions = CustomerAuction::whereHas('auction',function($q) {
                                    $q->orderBy('sold_at', 'asc');
                                })
                                ->where(['status' => $status, 'customer_id' => $user_id])
                                ->get();*/
            CustomerAuction::delete_old_favourites($till_date, $user_id, $now);

            return app('datatables')->collection($customer_auctions)
                ->addIndexColumn()
                ->editColumn('domain', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->domain.'" >
                            <span>' . $auction->auction->domain . '</span> 
                        </td>';
                })
                ->editColumn('status', function ($auction) {
                    $status = $auction->auction->current_status();
                    return '<td class="sorting_1" data-order="'.$auction->auction->status.'" >
                            <span>' . $status . '</span> 
                        </td>';
                })
                ->editColumn('start_date', function ($auction) {
                    return '<td class="sorting_1" data-order="'.date('d.m.Y H:i', strtotime($auction->auction->start_date)).'"> ' .date('d.m.Y H:i', strtotime($auction->auction->start_date))  . '  </td>';
                })
                ->editColumn('end_date', function ($auction) {
                    $end_date = Carbon::parse($auction->auction->end_date);
                    $end_price = $auction->auction->end_price;
                    $start_price = $auction->auction->start_price;
                    $days = $auction->auction->days;
                    $average_per_day = $auction->auction->average_per_day;
                    if (!$auction->auction->sold_to) {
                        $customer_bid = $auction->auction->heighest_bid;

                        if($customer_bid && $customer_bid->bid_type === 'normal'){
                            $diff = 0;
                            if($average_per_day > 0){
                                $bid_price = $customer_bid->bid_price;
                                /*$diff = (($bid_price - $end_price) / $average_per_day)  + 1;
                                $end_date = Carbon::parse($auction->auction->end_date)->subDay($diff);*/
                                $diff = (($start_price - $bid_price ) / $average_per_day);
                                $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);
                            }

                        }
                    }else if($auction->auction->sold_to){
                        $end_date = $auction->auction->sold_at;
                    }
                    return '<td class="sorting_1"  data-order="'.date('Y.m.d H:i', strtotime($end_date)).'"> ' . date('d.m.Y H:i', strtotime($end_date))   . ' </td>';
                })
                ->editColumn('start_price', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->auction->start_price.'">' . number_format($auction->auction->start_price, 0 , ',', '.') . '</td>';
                })
                ->addColumn('actual', function ($auction) {
                    $actual_price = $auction->auction->actual_price();
                    if ($actual_price == 0) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> - </td>';
                    }
                    if (is_numeric($actual_price)) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> '.number_format($actual_price, 0, ',', '.').'</td>';
                    }

                })
                ->addColumn('discount', function ($auction) {
                    $discount = $auction->auction->discount();
                    if(is_numeric($discount)){
                        return '<td class="sorting_1" data-order="'.$discount.'"> '.$discount.'% </td>';
                    }
                    return '<td class="sorting_1" data-order="0"> - </td>';
                })
                ->addColumn('remaining_time', function ($auction) use ($user_id) {
                    $closed = false;
                    $seconds = 0;
                    $end_date = Carbon::parse($auction->auction->end_date);
                    $start_date= Carbon::parse($auction->auction->start_date);
                    $end_price= $auction->auction->end_price;
                    $start_price = $auction->auction->start_price;
                    $average_per_day= $auction->auction->average_per_day;

                    if($end_date->isPast()) {
                        return '<td class="sorting_1"> - </td>';
                    }

                    else $seconds = $auction->auction->remaining_seconds($end_date);
                    if(!$start_date->isPast()){
                        $seconds = $auction->auction->remaining_seconds($start_date);
                        return '<td class="sorting_1"> - <span class="text-bold d-none data-countdown" data-countdown="'.($auction->auction->start_date).'" data-seconds="'.$seconds.'"></span></td>';
                    }
                    $customer_bid = $auction->auction->heighest_bid;

                    if($customer_bid){
                        $bid_price = $customer_bid->bid_price;
                        /*$diff = (($bid_price - $end_price) / $average_per_day) + 1;
                        $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);*/
                        $diff = (($start_price - $bid_price ) / $average_per_day);
                        $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);
                        if($end_date->isPast()){
                            $seconds = 0;
                            $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                        }
                        else {
                            $seconds = $auction->auction->remaining_seconds($end_date);
                        }

                    }
                    return '<td class="sorting_1">  <span class="text-bold text-red data-countdown" data-countdown="'.($auction->auction->end_date).'" data-seconds="'.$seconds.'"> </span>  </td>';
                })
                ->addColumn('offer', function ($auction) {
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) return '';
                    if($auction->sold_to) return '';
                    return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-success text-bold bid_manager"  data-id="'.$auction->auction->id.'">Bietmanager</button> </td>';
                })
                ->editColumn('end_price', function ($auction) use ($user_id) {
                    $class = 'text-dark';
                    if($auction->auction->sold_to){
                        if($auction->auction->sold_to == $user_id){
                            $class = 'text-success';
                        }else {
                            $class = 'text-danger';
                        }
                        $customer_bided_auction = $auction->auction->sold;
                        if ($customer_bided_auction) {
                            return '<td class="sorting_1" data-order="'.$customer_bided_auction->bid_price.'"><span class="'.$class.'">' . number_format($customer_bided_auction->bid_price, 0 , ',', '.') . '</span></td>';
                        }
                    }

                    $highest_bid = $auction->auction->heighest_bid;
                    if($highest_bid){
                        /*if($highest_bid->customer_id == $user_id){
                            $class = 'text-success';
                        }else {
                            $class = 'text-danger';
                        }*/
                        $customer_bid = CustomerAuctionBid::where(['auction_id' => $auction->auction_id, 'customer_id' => $user_id])->first();
                        if($highest_bid->customer_id == $user_id){
                            $class = 'text-success';
                        }elseif($customer_bid) {
                            $class = 'text-danger';
                        }
                        return '<td class="sorting_1" data-order="'.$highest_bid->bid_price.'"><span class="'.$class.'">'.number_format($highest_bid->bid_price, 0 , ',', '.').'</span> </td>';
                    }
                    return '<td class="sorting_1" data-order="'.$auction->auction->end_price.'">' . number_format($auction->auction->end_price, 0 , ',', '.') . '</td>';
                })
                ->addColumn('action', function ($auction)  {
                    $closed = '';
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) $closed = true;
                    return '<a href="javascript:;" class="remove_from_customer_auction"  '.($closed ? 'closed="closed"': '').' data-id="'.$auction->id.'" data-domain="'.$auction->auction->domain.'"><i class="fas fa-heart text-red font-medium my-1"></i></a>';

                })
                ->rawColumns(['domain', 'start_date','end_date','status','start_price',  'actual', 'offer','discount', 'end_price', 'remaining_time',  'action'])
                ->make(true);
        }

        $planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('start_date', '>', $now)
                                            ->where('sold_at', null);
                                    })
                                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                                    ->get()->count();


        $active = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                    $q->where('start_date', '<', $now)->where('sold_at', null)
                                        ->where('end_date', '>', $now);
                                })
                                ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                                ->get()->count();

        $sold = CustomerAuction::whereHas('auction',function($q) use ($now, $till_date) {
                                    $q->where('sold_at', '!=', null)->where('end_date', '<', $now)->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                                })
                                ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                                ->get()->take(10)->count();

        $finished = CustomerAuction::whereHas('auction',function($q) use ($till_date, $now) {
                                        $q->where('sold_at',  null)->where('end_date', '<', $now)
                                            ->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                                    })
                                    ->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id])
                                    ->get()->take(10)->count();

        $data['type'] =  $type;
        $data['planned'] =  $planned;
        $data['active'] =  $active;
        $data['sold'] =  $sold;
        $data['finished'] =  $finished;
        return  view('customer-portal.auction.favourite', $data);
    }

    public function watchlist(Request $request , $type)
    {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        if ($request->ajax()) {
            $status = CustomerAuction::$watchlist;
            if($type == 'planned'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('start_date', '>', $now)
                                            ->where('sold_at', null)->orderBy('sold_at', 'asc');
                                    })
                                    ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                    ->get();

            }
            if($type == 'active'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now) {
                                        $q->where('start_date', '<', $now)->where('sold_at', null)
                                            ->where('end_date', '>', $now)->orderBy('sold_at', 'asc');
                                    })
                                    ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                    ->get();
            }
            if($type == 'sold'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($now, $till_date) {
                                        $q->where('sold_to', '!=',  null)->where('end_date', '<', $now)->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                                    })
                                    ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                    ->get();
            }
            if($type == 'finish'){
                $customer_auctions = CustomerAuction::whereHas('auction',function($q) use ($till_date, $now) {
                                                        $q->where('sold_at',  null)->where('end_date', '<', $now)->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                                                    })
                                                    ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                                    ->get();
            }
            /*$status = CustomerAuction::auction_status($type);*/
           /* $status = CustomerAuction::$favourite;
            $customer_auctions = CustomerAuction::whereHas('auction',function($q) {
                                    $q->orderBy('sold_at', 'asc');
                                })
                                ->where(['status' => $status, 'customer_id' => $user_id])
                                ->get();*/
            CustomerAuction::delete_old_watchlist($till_date, $user_id, $now);
            return app('datatables')->collection($customer_auctions)
                ->addIndexColumn()
                ->editColumn('domain', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->domain.'" >
                            <span>' . $auction->auction->domain . '</span> 
                        </td>';
                })
                ->editColumn('status', function ($auction) {
                    $status = $auction->auction->current_status();
                    return '<td class="sorting_1" data-order="'.$auction->auction->status.'" >
                            <span>' . $status . '</span> 
                        </td>';
                })
                ->editColumn('start_date', function ($auction) {
                    return '<td class="sorting_1" data-order="'.date('d.m.Y H:i', strtotime($auction->auction->start_date)).'"> ' .date('d.m.Y H:i', strtotime($auction->auction->start_date))  . '  </td>';
                })
                ->editColumn('end_date', function ($auction) {
                    /* $end_date = $auction->auction->end_date;
                     if($auction->auction->sold_to){
                         $end_date = $auction->auction->sold_at;
                     }*/

                    $end_date = Carbon::parse($auction->auction->end_date);
                    $end_price = $auction->auction->end_price;
                    $start_price = $auction->auction->start_price;
                    $days = $auction->auction->days;
                    $average_per_day = $auction->auction->average_per_day;
                    if (!$auction->auction->sold_to) {
                        /*$customer_bid = $auction->customer_bid;*/
                        /*$customer_bid = CustomerAuctionBid::where(['auction_id' => $auction->auction_id, 'customer_id'=> $auction->customer_id])->orderBy('bid_price', 'desc')->first();*/
                        $customer_bid = $auction->auction->heighest_bid;

                        if($customer_bid && $customer_bid->bid_type === 'normal'){
                            $diff = 0;
                            if($average_per_day > 0){
                                $bid_price = $customer_bid->bid_price;
                               /* $diff = (($bid_price - $end_price) / $average_per_day)  + 1;
                               $end_date = Carbon::parse($auction->auction->end_date)->subDay($diff);*/
                                $diff = (($start_price - $bid_price ) / $average_per_day);
                                $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);
                            }

                        }
                    }else if($auction->auction->sold_to){
                        $end_date = $auction->auction->sold_at;
                    }
                    return '<td class="sorting_1"  data-order="'.date('Y.m.d H:i', strtotime($end_date)).'"> ' . date('d.m.Y H:i', strtotime($end_date))   . ' </td>';
                })
                ->editColumn('start_price', function ($auction) {
                    return '<td class="sorting_1" data-order="'.$auction->auction->start_price.'">' . number_format($auction->auction->start_price, 0 , ',', '.') . '</td>';
                })
                ->addColumn('actual', function ($auction) {
                    $actual_price = $auction->auction->actual_price();
                    if ($actual_price == 0) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> - </td>';
                    }
                    if (is_numeric($actual_price)) {
                        return '<td class="sorting_1" data-order="'.$actual_price.'"> '.number_format($actual_price, 0, ',', '.').'</td>';
                    }

                })
                ->addColumn('discount', function ($auction) {
                    $discount = $auction->auction->discount();
                    if(is_numeric($discount)){
                        return '<td class="sorting_1" data-order="'.$discount.'"> '.$discount.'% </td>';
                    }
                    return '<td class="sorting_1" data-order="0"> - </td>';
                })
                ->addColumn('remaining_time', function ($auction) use ($user_id) {
                    $closed = false;
                    $seconds = 0;
                    $end_date = Carbon::parse($auction->auction->end_date);
                    $start_date= Carbon::parse($auction->auction->start_date);
                    $end_price= $auction->auction->end_price;
                    $start_price= $auction->auction->start_price;
                    $average_per_day= $auction->auction->average_per_day;

                    if($end_date->isPast()) {
                        return '<td class="sorting_1"> - </td>';
                    }

                    else $seconds = $auction->auction->remaining_seconds($end_date);
                    if(!$start_date->isPast()){
                        $seconds = $auction->auction->remaining_seconds($start_date);
                        return '<td class="sorting_1"> - <span class="text-bold d-none data-countdown" data-countdown="'.($auction->auction->start_date).'" data-seconds="'.$seconds.'"></span></td>';
                    }
                    $customer_bid = $auction->auction->heighest_bid;

                    if($customer_bid){
                        $bid_price = $customer_bid->bid_price;
                        /*$diff = (($bid_price - $end_price) / $average_per_day) + 1;
                        $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);*/
                        $diff = (($start_price - $bid_price ) / $average_per_day);
                        $end_date = Carbon::parse($auction->auction->start_date)->addDays($diff);
                        if($end_date->isPast()){
                            $seconds = 0;
                            $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                        }
                        else {
                            $seconds = $auction->auction->remaining_seconds($end_date);
                        }
                    }
                    return '<td class="sorting_1">  <span class="text-bold text-red data-countdown" data-countdown="'.($auction->auction->end_date).'" data-seconds="'.$seconds.'"> </span>  </td>';
                })
                ->addColumn('offer', function ($auction) {
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) return '';
                    if($auction->sold_to) return '';
                    return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-success text-bold bid_manager"  data-id="'.$auction->auction->id.'">Bietmanager</button> </td>';
                })
                ->editColumn('end_price', function ($auction) use ($user_id) {
                    $class = 'text-dark';
                    if($auction->auction->sold_to){
                        if($auction->auction->sold_to == $user_id){
                            $class = 'text-success';
                        }else {
                            $class = 'text-danger';
                        }
                        $customer_bided_auction = $auction->auction->sold;
                        if ($customer_bided_auction /*&& $customer_bided_auction->bid_type == 'immediately'*/) {
                            return '<td class="sorting_1" data-order="'.$customer_bided_auction->bid_price.'"><span class="'.$class.'">' . number_format($customer_bided_auction->bid_price, 0 , ',', '.') . '</span></td>';
                        }
                    }

                    $highest_bid = $auction->auction->heighest_bid;
                    if($highest_bid){
                        $customer_bid = CustomerAuctionBid::where(['auction_id' => $auction->auction_id, 'customer_id' => $user_id])->first();
                        if($highest_bid->customer_id == $user_id){
                            $class = 'text-success';
                        }elseif($customer_bid) {
                            $class = 'text-danger';
                        }
                        return '<td class="sorting_1" data-order="'.$highest_bid->bid_price.'"><span class="'.$class.'">'.number_format($highest_bid->bid_price, 0 , ',', '.').'</span> </td>';
                    }
                    return '<td class="sorting_1" data-order="'.$auction->auction->end_price.'">' . number_format($auction->auction->end_price, 0 , ',', '.') . '</td>';
                })
                ->addColumn('action', function ($auction)  {
                    $closed = '';
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) $closed = true;
                    return '<a href="javascript:;" class="remove_from_customer_auction"  '.($closed ? 'closed="closed"': '').' data-id="'.$auction->id.'" data-domain="'.$auction->auction->domain.'"><i class="fas fa-bell text-primary font-medium my-1"></i></a>';

                })
                ->rawColumns(['domain', 'start_date','end_date','status','start_price',  'actual', 'offer','discount', 'end_price', 'remaining_time',  'action'])
                ->make(true);
        }

            $planned = CustomerAuction::whereHas('auction',function($q) use ($now) {
                $q->where('start_date', '>', $now)
                    ->where('sold_at', null)->orderBy('sold_at', 'asc');
            })
                ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                ->get()->count();


            $active = CustomerAuction::whereHas('auction',function($q) use ($now) {
                $q->where('start_date', '<', $now)->where('sold_at', null)
                    ->where('end_date', '>', $now)->orderBy('sold_at', 'asc');
            })
                ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                ->get()->count();

            $sold = CustomerAuction::whereHas('auction',function($q) use ($till_date, $user_id) {
                        $q->where('sold_at', '!=', null)
                            ->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                    })
                ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                ->get()->take(10)->count();

            $finished = CustomerAuction::whereHas('auction',function($q) use ($now, $till_date) {
                                            $q->where('sold_at',   null)->where('end_date', '<', $now)
                                                ->where('end_date', '>', $till_date)->orderBy('end_date', 'asc');
                                        })
                                        ->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id])
                                        ->get()->take(10)->count();

        $data['type'] =  $type;
        $data['planned'] =  $planned;
        $data['active'] =  $active;
        $data['sold'] =  $sold;
        $data['finished'] =  $finished;
        return  view('customer-portal.auction.watchlist',  $data);
    }

    public function destroy(CustomerAuction $customer_auction) {
        $customer_auction->delete();
        return response()->json([
            'message' => 'Removed from watchlist',
            'customerAuction' => $customer_auction,
        ], 200);
    }

    public function add_to_watchlist(Request $request) {
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $customer_auction = CustomerAuction::where([
            'auction_id' => $request->id,
            'customer_id' => $user_id,
            'status' => CustomerAuction::$watchlist
        ])->first();
        if($customer_auction){
            return response()->json([
                'message' => 'All ready added',
            ], 200);
        }
        $customerAuction = CustomerAuction::create([
            'auction_id' => $request->id,
            'customer_id' => $user_id,
            'status' => CustomerAuction::$watchlist
        ]);

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        CustomerAuction::delete_old_watchlist($till_date, $user_id, $now);



        $auction = Auction::whereId($request->id)->first();
        $end_date = Carbon::parse($auction->end_date);
        if ($auction->sold_at) {
            $customer = Customer::whereId($user_id)->first();
            $emailTemplate = EmailTemplate::find(14);
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $customer->last_name;
            if($customer->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $customer->last_name;

            }
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
            $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]', '[[endpreis]]'] , [$auction->domain , $name , $auction->sold_to->bid_price ] , $emailTemplate->email_text);
            $emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
        }
        $bid = CustomerAuction::where('auction_id', $request->id)->whereStatus(CustomerAuction::$bided)->orderBy('id', 'desc')->first();
        if ($bid && $end_date->isPast()) {
            $customer = Customer::whereId($bid->customer_id)->first();
            $data['subject'] = ' Adomino.net: Watchlist für die Domain '. $auction->domain;
            $data['message'] = 'Die Auktion für die Domain '.$auction->domain.' wurde gerade beendet. Sie werden für die Domain keine
                                weiteren Watchlist-E-Mails mehr erhalten.';
            $data['regards'] = 'Ihr Adomino.net Team';
            $emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
        }

        $already_added_in_watchlists = CustomerAuction::where('auction_id', $request->id)->whereStatus(CustomerAuction::$watchlist)->where('customer_id', '!=',$user_id)->orderBy('id', 'desc')->get();
        if ($already_added_in_watchlists) {
            foreach ($already_added_in_watchlists as $already_added_in_watchlist){
                $customer = Customer::whereId($already_added_in_watchlist->customer_id)->first();
                $emailTemplate = EmailTemplate::find(10);
                $gender = 'Sehr geehrter Herr';
                $name = $gender . ' ' . $customer->last_name;
                if($customer->title === 'mrs')  {
                    $gender = 'Sehr geehrte Frau ';
                    $name = $gender . ' ' . $customer->last_name;

                }
                $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
                $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]' ] , [$auction->domain, $name] , $emailTemplate->email_text);

                $emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
            }
        }
        return response()->json([
            'message' => 'Add To Customer Watchlist',
            'customerAuction' => $customerAuction,
            'data' => Auction::whereHas('customer_auction_watchlist',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id]);
            })
                ->where('sold_to', null)
                ->whereBetween('end_date', [$till_date, $now])
                ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get(),

        ], 200);
    }

    public function add_to_favourite(Request $request) {
        $user_id = Auth::guard(Customer::$guardType)->id();
        $customer_auction = CustomerAuction::where([
            'auction_id' => $request->id,
            'customer_id' => $user_id,
            'status' => CustomerAuction::$favourite
        ])->first();
        if($customer_auction){
            return response()->json([
                'message' => 'All ready added',
            ], 200);
        }
        $customerAuction = CustomerAuction::create([
            'auction_id' => $request->id,
            'customer_id' => $user_id,
            'status' => CustomerAuction::$favourite
        ]);
        $auction = Auction::whereId($request->id)->first();

        $already_added_in_watchlists = CustomerAuction::where('auction_id', $request->id)->whereStatus(CustomerAuction::$watchlist)->where('customer_id', '!=',$user_id)->orderBy('id', 'desc')->get();
        if ($already_added_in_watchlists) {
           foreach ($already_added_in_watchlists as $already_added_in_watchlist){
               $customer = Customer::whereId($already_added_in_watchlist->customer_id)->first();
               $data['subject'] = 'Adomino.net: Watchlist für die Domain '. $auction->domain;

               $gender = 'Sehr geehrter Herr';
               $name = $gender . ' ' . $customer->last_name;
               if($customer->title === 'mrs')  {
                   $gender = 'Sehr geehrte Frau ';
                   $name = $gender . ' ' . $customer->last_name;
               }

               $emailTemplate = EmailTemplate::find(11);
               $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
               $data['message'] = str_replace(['[[domain]]' ,'[[anrede-nachname]]' ] , [$auction->domain , $name] , $emailTemplate->email_text);


               $emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
           }
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $till_date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        CustomerAuction::delete_old_favourites($till_date, $user_id, $now);

        return response()->json([
            'message' => 'Add To Customer Favourites',
            'customerAuction' => $customerAuction,
        ], 200);
    }

    public function customer_auctions($type){
        $user = Auth::guard(Customer::$guardType)->user();
        $user_id = $user->id;
        $status = CustomerAuction::auction_status($type);
        $customer_auctions = CustomerAuction::whereHas('auction',function($q) {
                                    $q->orderBy('sold_at', 'asc');
                                })
                            ->where(['status' => $status, 'customer_id' => $user_id])
                            ->get();
        return app('datatables')->collection($customer_auctions)
            ->addIndexColumn()
            ->editColumn('domain', function ($auction) {
                return '<td class="sorting_1" data-order="'.$auction->domain.'" >
                            <span>' . $auction->auction->domain . '</span> 
                        </td>';
            })
            ->editColumn('status', function ($auction) {
                $status = $auction->auction->current_status();
                return '<td class="sorting_1" data-order="'.$auction->auction->status.'" >
                            <span>' . $status . '</span> 
                        </td>';
            })
            ->editColumn('start_date', function ($auction) {
                return '<td class="sorting_1" data-order="'.date('d.m.Y H:i', strtotime($auction->auction->start_date)).'"> ' .date('d.m.Y H:i', strtotime($auction->auction->start_date))  . '  </td>';
            })
            ->editColumn('end_date', function ($auction) {
               /* $end_date = $auction->auction->end_date;
                if($auction->auction->sold_to){
                    $end_date = $auction->auction->sold_at;
                }*/

                $end_date = Carbon::parse($auction->auction->end_date);
                $end_price = $auction->auction->end_price;
                $start_price = $auction->auction->start_price;
                $days = $auction->auction->days;
                $average_per_day = $auction->auction->average_per_day;
                if (!$auction->auction->sold_to) {
                    /*$customer_bid = $auction->customer_bid;*/
                    /*$customer_bid = CustomerAuctionBid::where(['auction_id' => $auction->auction_id, 'customer_id'=> $auction->customer_id])->orderBy('bid_price', 'desc')->first();*/
                    $customer_bid = $auction->auction->heighest_bid;

                    if($customer_bid && $customer_bid->bid_type === 'normal'){
                        $diff = 0;
                        if($average_per_day > 0){
                            $bid_price = $customer_bid->bid_price;
                            /*$diff = (($bid_price - $end_price) / $average_per_day)  + 1;*/
                            $diff = (($start_price - $bid_price ) / $average_per_day);
                            $end_date = Carbon::parse($auction->auction->end_date)->subDay($diff);
                        }

                    }
                }else if($auction->auction->sold_to){
                    $end_date = $auction->auction->sold_at;
                }
                return '<td class="sorting_1"  data-order="'.date('Y.m.d H:i', strtotime($end_date)).'"> ' . date('d.m.Y H:i', strtotime($end_date))   . ' </td>';
            })
            ->editColumn('start_price', function ($auction) {
                return '<td class="sorting_1" data-order="'.$auction->auction->start_price.'">' . number_format($auction->auction->start_price, 0 , ',', '.') . '</td>';
            })
            ->addColumn('actual', function ($auction) {
                $actual_price = $auction->auction->actual_price();
                if ($actual_price == 0) {
                    return '<td class="sorting_1" data-order="'.$actual_price.'"> - </td>';
                }
                if (is_numeric($actual_price)) {
                    return '<td class="sorting_1" data-order="'.$actual_price.'"> '.number_format($actual_price, 0, ',', '.').'</td>';
                }

            })
            ->addColumn('discount', function ($auction) {
                $discount = $auction->auction->discount();
                if(is_numeric($discount)){
                    return '<td class="sorting_1" data-order="'.$discount.'"> '.$discount.'% </td>';
                    /*return '<td class="sorting_1" data-order="'.$discount.'"> '.number_format($discount, 0, ',', '.').'% </td>';*/

                }
                return '<td class="sorting_1" data-order="0"> - </td>';
            })
            ->addColumn('remaining_time', function ($auction) use ($user_id, $type) {
                $closed = false;
                $seconds = 0;
                $end_date = Carbon::parse($auction->auction->end_date);
                $start_date= Carbon::parse($auction->auction->start_date);
                $end_price= $auction->auction->end_price;
                $start_price= $auction->auction->start_price;
                $average_per_day= $auction->auction->average_per_day;

                if($end_date->isPast()) {
                    return '<td class="sorting_1"> - </td>';
                }

                else $seconds = $auction->auction->remaining_seconds($end_date);
                if(!$start_date->isPast()){
                    $seconds = $auction->auction->remaining_seconds($start_date);
                    return '<td class="sorting_1"> - <span class="text-bold d-none data-countdown" data-countdown="'.($auction->auction->start_date).'" data-seconds="'.$seconds.'"></span></td>';
                }
                $customer_bid = $auction->auction->heighest_bid;

                if($customer_bid){
                    $bid_price = $customer_bid->bid_price;
                    /*$diff = (($bid_price - $end_price) / $average_per_day) + 1;*/
                    $diff = (($start_price - $bid_price ) / $average_per_day);
                    $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);
                    if($end_date->isPast()){
                        $seconds = 0;
                        $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                    }
                    else {
                        $seconds = $auction->auction->remaining_seconds($end_date);
                    }
                    /*if ($bid_price == $end_price) {
                        $end_date = Carbon::parse($auction->auction->end_date)->addDay(1);
                    }else {
                        $diff = (($bid_price - $end_price) / $average_per_day) + 1;
                        $end_date = Carbon::parse($auction->auction->end_date)->subDays($diff);
                        if($end_date->isPast()){
                            $seconds = 0;
                            $auction->auction->normal_auction_mark_sold($end_date, $user_id);
                        }
                        else {
                            $seconds = $auction->auction->remaining_seconds($end_date);
                        }
                    }*/

                }
                return '<td class="sorting_1">  <span class="text-bold text-red data-countdown" data-countdown="'.($auction->auction->end_date).'" data-seconds="'.$seconds.'"> </span>  </td>';
            })
            ->addColumn('offer', function ($auction) {
                $end_date = Carbon::parse($auction->auction->end_date);
                if($end_date->isPast()) return '';
                if($auction->sold_to) return '';
                return '<td class="sorting_1 "> <button type="button" class="btn btn-md btn-success text-bold bid_manager"  data-id="'.$auction->auction->id.'">Bieten</button> </td>';
            })
            ->editColumn('end_price', function ($auction) use ($user_id, $type) {
                if($auction->auction->sold_to){
                    /*$customer_bided_auction = CustomerAuction::where(['auction_id' => $auction->auction_id, 'customer_id' =>  $auction->auction_id, 'status' =>  CustomerAuction::$bided])->first();*/
                    $customer_bided_auction = $auction->auction->sold;
                    if ($customer_bided_auction && $customer_bided_auction->bid_type == 'immediately') {
                        return '<td class="sorting_1" data-order="'.$customer_bided_auction->bid_price.'">' . number_format($customer_bided_auction->bid_price, 0 , ',', '.') . '</td>';
                    }
                }

                $highest_bid = $auction->auction->heighest_bid;
                if($highest_bid){
                    if($highest_bid->customer_id == $user_id){
                        $class = 'text-success';
                    }else {
                        $class = 'text-danger';
                    }
                    return '<td class="sorting_1" data-order="'.$highest_bid->bid_price.'"><span class="'.$class.'">'.number_format($highest_bid->bid_price, 0 , ',', '.').'</span> </td>';
                }
                return '<td class="sorting_1" data-order="'.$auction->auction->end_price.'">' . number_format($auction->auction->end_price, 0 , ',', '.') . '</td>';
            })
            ->addColumn('action', function ($auction) use ($type) {
                if($type == CustomerAuction::status(CustomerAuction::$watchlist)){
                    $closed = '';
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) $closed = true;
                    return '<a href="javascript:;" class="remove_from_customer_auction"  '.($closed ? 'closed="closed"': '').' data-id="'.$auction->id.'" data-domain="'.$auction->auction->domain.'"><i class="fas fa-bell text-primary font-medium my-1"></i></a>';
                }else{
                    $closed = '';
                    $end_date = Carbon::parse($auction->auction->end_date);
                    if($end_date->isPast()) $closed = true;
                    return '<a href="javascript:;" class="remove_from_customer_auction"  '.($closed ? 'closed="closed"': '').' data-id="'.$auction->id.'" data-domain="'.$auction->auction->domain.'"><i class="fas fa-heart text-red font-medium my-1"></i></a>';
                }
            })
            ->rawColumns(['domain', 'start_date','end_date','status','start_price',  'actual', 'offer','discount', 'end_price', 'remaining_time',  'action'])
            ->make(true);
    }

    public function bid(Request $request, $id){

        $user = Auth::guard(Customer::$guardType)->user();
        $current_user_level =  $user->current_level();
        $auction = Auction::findOrFail($id);
        $start_date = Carbon::parse($auction->start_date);
        $end_date = Carbon::parse($auction->end_date);
        if (!$auction) {
            return redirect('404');
        }
        if ($auction->sold_to) {
            return redirect()->back();
        }

        if($end_date->isPast()){
            return redirect()->back();
        }
        $data['current_status'] = 'planned';
        if($start_date->isPast()){
            $data['current_status'] = 'active';
        }
        $start_price = $auction->start_price;
        $end_price = $auction->end_price;
        /*$minimum_price = $auction->minimum_price();*/
        $minimum_price = $end_price;
        $instant_price = $start_date->isPast() ?  $auction->actual_price() : $start_price;

        /*$highest_bit = CustomerAuction::where('auction_id', $auction->id)->orderBy('bid_price', 'desc')->first();*/
        /*$highest_bit = CustomerAuctionBid::where('auction_id', $auction->id)->orderBy('bid_price', 'desc')->first();*/
        $highest_bit = $auction->heighest_bid;
        /*return response()->json([
            '$highest_bit' =>$highest_bit
        ]);*/
        $data['existed_bid_price'] = null;
        $heights_customer_bid = null;
        if($highest_bit && $highest_bit->bid_price ){
            $highest_bid_price =  $highest_bit->bid_price;
            /*if ($highest_bit->customer_id !== $user->id) {
                $data['existed_bid_price'] = $highest_bit->bid_price;
                $prices = $auction->calculate_bid_price_range();
            }else{
                $prices = $auction->calculate_bid_price_range($highest_bid_price);
            }*/
            $heights_customer_bid = $highest_bit->bid_price;
            $data['existed_bid_price'] = $heights_customer_bid;
            $prices = $auction->calculate_bid_price_range($highest_bid_price);

        }else {
            $prices = $auction->calculate_bid_price_range();
        }
        /*return response()->json([
            '$prices' =>$prices
        ]);*/
        $customer_auction = CustomerAuction::whereStatus(CustomerAuction::$bided)->where('customer_id','!=', $user->id)->get();
        $next_step_price = $auction->latest_price();
        /*$next_step_price = $auction->actual_price();*/
        sort($prices);
        $data['prices'] =  $prices;
        if($request->ajax()){
            /*If the customer only has certification for level 1*/
            if($current_user_level == 1){
                /*if($start_price <= 1000){*/
                if($end_price <= 1000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 2 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($end_price <= 1000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 2 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($end_price > 1000 and $end_price <= 10000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($end_price > 10000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($heights_customer_bid && $heights_customer_bid > 1000 and $heights_customer_bid <= 10000   ){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain von mindestens 1.000 EUR abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if( $heights_customer_bid > 10000   ){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain von mindestens 10.000 EUR abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
            }
            /*If the customer only has certification for level 2*/
            if($current_user_level == 2){
                if($minimum_price > 1000 and $minimum_price <= 10000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($minimum_price > 10000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }

                if($heights_customer_bid && $heights_customer_bid > 1000 and $heights_customer_bid <= 10000   ){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain von mindestens 1.000 EUR abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if( $heights_customer_bid > 10000   ){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain von mindestens 10.000 EUR abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }

            }
            /*If the customer only has certification for level 3*/
            if($current_user_level == 3){
                if($minimum_price > 10000){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }
                if($heights_customer_bid &&  $heights_customer_bid > 10000   ){
                    return response()->json([
                        'title' => 'Gebot abgeben',
                        'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain von mindestens 10.000 EUR abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                        'button' => 'Zurück',
                        'proceed' => false,
                    ], 200);
                }

            }
            /*If the customer only has certification level 1, 2 or 3 and the minimum price is more than 10,000 EUR*/
            if($minimum_price > 10000 && $current_user_level < 4){
                return response()->json([
                    'title' => 'Gebot abgeben',
                    'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                    'button' => 'Zurück',
                    'proceed' => false,
                ], 200);
            }
            /*If the customer only has certification level 1, 2 or 3 and another customer has already
                placed a bid and the next step would be more than 10,000 EUR,*/

            /*if($current_user_level < 4 && $customer_auction && $next_step_price > 10000  ){
                return response()->json([
                    'title' => 'Gebot abgeben',
                    'message' => 'Ein anderer Kunde hat bereits ein Gebot für die Domain abgegeben. Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 4 haben.',
                    'button' => 'Zurück',
                    'proceed' => false,
                ], 200);
            }*/


            if($minimum_price <= 10000  && $current_user_level ===  3){
                return response()->json([
                    'message' => '',
                    'title' => '',
                    'proceed' => true,
                ], 200);
            }

            /*If the customer only has certification level 1 or 2 and the minimum price is between EUR 1,001
                and EUR 10,000,*/
            /*if(($current_user_level == 1 || $current_user_level == 2) and ( $minimum_price > 1001 and $minimum_price < 10000) ){
                return response()->json([
                    'title' => 'Gebot abgeben',
                    'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                    'button' => 'Zurück',
                    'proceed' => false,
                ], 200);
            }*/
            /*If the customer only has certification level 1 or 2 and the next_step_price price is between EUR 1,001
                 and EUR 10,000,*/
            /*if(($current_user_level == 1 || $current_user_level == 2) and $customer_auction and ( $next_step_price > 1001 and $next_step_price < 10000) ){
                return response()->json([
                    'title' => 'Gebot abgeben',
                    'message' => 'Um ein Gebot abgeben zu können, müssen Sie den Zertifizierungslevel 3 haben.',
                    'button' => 'Zurück',
                    'proceed' => false,
                ], 200);
            }*/






            return response()->json([
                'message' => '',
                'title' => '',
                'proceed' => true,
            ], 200);
        }

        $data['instant_price'] = $instant_price ;
        $data['auction'] = $auction;

        $data['id'] = $id;
        $data['minimum_price'] = $minimum_price;
        $data['current_user_level'] = $current_user_level;
        $bids = [];
        /*$customer_bids = CustomerAuction::where('auction_id', $id)->get();*/
        /*$customer_bids = CustomerAuctionBid::where('auction_id', $id)->get();*/
        $customer_bids = $auction->bids;
        foreach ($customer_bids as $customer_bid){
            if($customer_bid->customer_id == $user->id){
                $bids[$customer_bid->bid_price] = 'Ich';
            }  else{
                $bids[$customer_bid->bid_price] = 'Bieter ' . $customer_bid->customer_id;
            }
        }
       /* return $bids;*/
        $data['bids'] = $bids;
        if($current_user_level === 1) return redirect()->back();
        if($minimum_price <= 10000 && $current_user_level === 3) return view('customer-portal.auction.bid_manager', $data);
        if($minimum_price > 10000 && $current_user_level < 4) return redirect()->back();
        /*if($current_user_level < 4 && $customer_auction && $next_step_price > 10000  ) return redirect()->back();
        if(($current_user_level === 1 || $current_user_level === 2) and ( $minimum_price > 1001 and $minimum_price < 10000) ) return redirect()->back();
        if(($current_user_level === 1 || $current_user_level === 2) and $customer_auction and ( $next_step_price > 1001 and $next_step_price < 10000) ) return redirect()->back();*/
        return view('customer-portal.auction.bid_manager', $data);


    }

    public function submit_bid(Request $request, $id){
        $auction = Auction::findOrFail($id);
        if($auction->sold){
            return response()->json([
                'message' => 'Die Auktion ist verkauft.',
                'status' => 400 ,
            ], 200);
        }
        $user = Auth::guard(Customer::$guardType)->user();
        $request['customer_id'] = $user->id;
        $request['status'] = CustomerAuction::$bided;
        $request['current_price'] = $auction->actual_price();
        $emailSent = null;
        $customer_bid_auction = CustomerAuction::where(['customer_id' => $user->id, 'auction_id' => $id, 'status' => CustomerAuction::$bided ])->first();

        if(!$customer_bid_auction){
            $customer_bid_auction = CustomerAuction::create($request->all());
        }
        $customer_bid_auction->customer_auction_bids()->create($request->all());

        if ($request->bid_type == 'immediately') {
            $auction->update([
                'end_date' => Carbon::now(),
                'sold_at' => Carbon::now(),
                'sold_to' => $user->id,
                'status' => Auction::$sold,
            ]);
            $domain = Domain::where('domain',$auction->domain)->first();
            $domain->update([
                'landingpage_mode' => Domain::$auction_sold
            ]);
            Auction::sold_to_customer_email($auction->domain, $user->email, 'immediately', $request->bid_price, $user);
            /*Auction::marked_favourite_email($id, $auction, $user);*/
            Auction::watchlist_email($id, $auction, $user);
        }else {
            //email template edded by irtaza 22-02-2021
            $gender = 'Sehr geehrter Herr';
            $name = $gender . ' ' . $user->last_name;
            if($user->title === 'mrs')  {
                $gender = 'Sehr geehrte Frau ';
                $name = $gender . ' ' . $user->last_name;

            }
            $emailTemplate = EmailTemplate::find(16);
            $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
            $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]', '[[gebotspreis]]'] , [$auction->domain, $name, number_format($request->bid_price, 0, ',', '.')] , $emailTemplate->email_text);
            $data['regards'] = 'Ihr Adomino.net Team';

            Mail::to($user->email)->send(new GenralAuctionMail($data));

            // $data['subject'] = 'Adomino.net: Ihr Gebot für die Domain '. $auction->domain;
            // $data['message'] = 'Wir bestätigen Ihnen, dass Sie für die Domain '. $auction->domain.' ein Gebot über '.number_format($request->bid_price, 0, ',', '.').' EUR (netto) abgegeben haben. Sollten Sie von einem anderen Bieter überboten werden, erhalten Sie von uns ein weiteres E-Mail.';
            // $data['regards'] = 'Ihr Adomino.net Team';
            // $emailSent = Mail::to($user->email)->bcc(env('ADMIN_EMAIL'))->send(new GenralAuctionMail($data));
            Auction::bidding_email_to_watchlist($id, $auction, $user);
            /*Add To Watch list on bid*/
            $customer_auction = CustomerAuction::where([ 'auction_id' => $id, 'customer_id' => $user->id, 'status' => CustomerAuction::$watchlist ])->first();
            if(!$customer_auction){
                CustomerAuction::create([
                    'auction_id' => $id,
                    'customer_id' => $user->id,
                    'status' => CustomerAuction::$watchlist
                ]);

            }
        }

        $highest_bid = $auction->heighest_bid;
        if($highest_bid && $highest_bid->customer_id == $user->id){
            $second_highest_bid = CustomerAuction::where('auction_id', $id)->where('customer_id', '!=',$user->id)->orderBy('bid_price', 'desc')->first();
            if ($second_highest_bid ) {
                if($auction->sold_to){
                    $customer = Customer::whereId($second_highest_bid->customer_id)->first();
                    $gender = 'Sehr geehrter Herr';
                    $name = $gender . ' ' . $customer->last_name;
                    if($customer->title === 'mrs')  {
                        $gender = 'Sehr geehrte Frau ';
                        $name = $gender . ' ' . $customer->last_name;

                    }
                    $emailTemplate = EmailTemplate::find(9);
                    $data['subject'] =  str_replace(['[[domain]]'] , [$auction->domain] , $emailTemplate->email_subject);
                    $data['message'] =  str_replace(['[[domain]]', '[[anrede-nachname]]', '[[vkpreis]]'] , [$auction->domain,$name, number_format($second_highest_bid->bid_price, 0, ',', '.')] , $emailTemplate->email_text); 'Ein anderer Bieter hat die Domain '.$auction->domain.' gerade gekauft. Es tut uns sehr leid, dass Sie für die Domain nicht Höchstbieter waren. Die Auktion ist somit beendet.';

                    /*$data['subject'] = 'Adomino.net: Ihr Gebot für die Domain '. $auction->domain;
                    $data['message'] = 'Ein anderer Bieter hat die Domain '.$auction->domain.' gerade gekauft. Es tut uns sehr leid, dass Sie für die Domain nicht Höchstbieter waren. Die Auktion ist somit beendet.';
                    $data['regards'] = 'Ihr Adomino.net Team';*/
                    $emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
                }else if ($second_highest_bid->customer_id !== $user->id) {
                    $customer = Customer::whereId($second_highest_bid->customer_id)->first();
                    // email template added by irtaza 22-02-2022
                    $gender = 'Sehr geehrter Herr';
                    $name = $gender . ' ' . $customer->last_name;
                    if($customer->title === 'mrs')  {
                        $gender = 'Sehr geehrte Frau ';
                        $name = $gender . ' ' . $customer->last_name;
                    }
                    $emailTemplate = EmailTemplate::find(17);
                    $data['subject'] = str_replace(['[[domain]]'] , [$auction->domain], $emailTemplate->email_subject);
                    $data['message'] = str_replace(['[[domain]]', '[[anrede-nachname]]'] , [$auction->domain , $name ] , $emailTemplate->email_text);
                    $data['regards'] = 'Ihr Adomino.net Team';
                    // $data['subject'] = 'Adomino.net: Sie wurden überboten für die Domain '. $auction->domain;
                    // $data['message'] = 'Wir müssen Ihnen leider mitteilen, dass Sie für die Domain '.$auction->domain.' überboten wurden. Sie haben jedoch im Bietmanager die Möglichkeit, das Gebot des anderen Bieters zu überbieten oder die Domain sofort zu kaufen.';
                    // $data['regards'] = 'Ihr Adomino.net Team';
                    //$emailSent = Mail::to($customer->email)->send(new GenralAuctionMail($data));
                    Mail::to($customer->email)->send(new GenralAuctionMail($data));
                }

             }
        }
        return response()->json([
            'message' => 'Bid Created Successfully',
            'emailSent' => $emailSent ,
            'status' => 200 ,
        ], 200);

    }

    public function get_bidder_list_modal(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        $user = Auth::guard(Customer::$guardType)->user();
        $auction = Auction::find($request->id);
        $customer_bids = $auction->bids;
        $bids = [];
        foreach ($customer_bids as $customer_bid){
            if($customer_bid->customer_id == $user->id){
                $bids[$customer_bid->bid_price] = 'Ich';
            }  else{
                $bids[$customer_bid->bid_price] = 'Bieter ' . $customer_bid->customer_id;
            }
        }

        $prices = $auction->all_step_prices();
        sort($prices);
        $return_array['ModalTitle'] = 'Bieterliste - ' . $auction->domain;
        if ($bids) {
            $return_array['bids'] = $bids;
            $return_array['domain'] = $auction->domain;
            $return_array['prices'] = $prices;
        }else {
            $return_array['message'] = 'Diese Auktion hat noch kein Gebot erhalten.';
            if($request->type == 'sold'){
                $return_array['message'] = 'Diese Auktion hat kein Gebot erhalten.';
            }

        }



        return (string)view('customer-portal.layout.modals.bidder-list')->with($return_array);
    }

}
