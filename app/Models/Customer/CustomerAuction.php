<?php

namespace App\Models\Customer;

use App\Models\Admin\Auction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAuction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'auction_id',
        'status',
        'bid_type',
        'current_price',
        'bid_price',
    ];

    public static $watchlist = 1;
    public static $favourite = 2;
    public static $bided = 3;

    public static function status($index = null){

        $status = [
            1 => 'watchlist',
            2 => 'favourite',
        ];

        if($index){
            return $status[$index];
        }
        return $status;

    }

    public static function auction_status($type): int {

        $status = [
            'watchlist' => 1,
            'favourite' => 2,
        ];
        return $status[$type];
    }

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }


    public function customer_auction_bids(){
        return $this->hasMany(CustomerAuctionBid::class, 'customer_auction_id', 'id');
    }
    public function customer_bid(){
        return $this->hasOne(CustomerAuctionBid::class, 'customer_auction_id', 'id')->latest();
    }


    public static function delete_old_watchlist($till_date, $user_id, $now){

        $finished_auctions_watchlist_ids = [];
        $latest_ten_finished_watchlist = Auction::whereHas('customer_auction_watchlist',function($q) use ($user_id) {
                                            $q->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id]);
                                        })
                                        ->where('sold_to', null)
                                        ->whereBetween('end_date', [$till_date, $now])
                                        ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get()->take(10);
        if ($latest_ten_finished_watchlist) {
            foreach ($latest_ten_finished_watchlist as $item) $finished_auctions_watchlist_ids[] = $item->id;
            $all_finished_watchlist = Auction::whereHas('customer_auction_watchlist',function($q) use ($user_id) {
                    $q->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id]);
                })
                ->where('sold_to', null)
                ->whereNotIn('id', $finished_auctions_watchlist_ids)
                ->whereBetween('end_date', [$till_date, $now])
                ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get();
            if ($all_finished_watchlist) {
                foreach ($all_finished_watchlist as $item) {
                    $watchlist_item= CustomerAuction::where('auction_id', $item->id)->first();
                    if($watchlist_item) $watchlist_item->delete();
                };
            }
        }

        $sold_auctions_watchlist_ids = [];

        $latest_ten_sold_watchlist = Auction::whereHas('customer_auction_watchlist',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id]);
            })
            ->whereNotNull('sold_to')
            ->whereBetween('end_date', [$till_date, $now])
            ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get()->take(10);
        if ($latest_ten_sold_watchlist) {
            foreach ($latest_ten_sold_watchlist as $item) $sold_auctions_watchlist_ids[] = $item->id;
            $all_sold_watchlist = Auction::whereHas('customer_auction_watchlist',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$watchlist, 'customer_id' => $user_id]);
            })
                ->whereNotNull('sold_to')
                ->whereNotIn('id', $sold_auctions_watchlist_ids)
                ->whereBetween('end_date', [$till_date, $now])
                ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get();
            if ($all_sold_watchlist) {
                foreach ($all_sold_watchlist as $item) {
                    $watchlist_item= CustomerAuction::where('auction_id', $item->id)->first();
                    if($watchlist_item) $watchlist_item->delete();

                };
            }
        }
    }

    public static function delete_old_favourites($till_date, $user_id, $now){
        $finished_auctions_favourites_ids = [];
        $latest_ten_finished_favourites = Auction::whereHas('customer_auction_favourites',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id]);
            })
            ->where('sold_to', null)
            ->whereBetween('end_date', [$till_date, $now])
            ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get()->take(10);
        if ($latest_ten_finished_favourites) {
            foreach ($latest_ten_finished_favourites as $item) $finished_auctions_favourites_ids[] = $item->id;
            $all_finished_favourites = Auction::whereHas('customer_auction_favourites',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id]);
            })
                ->where('sold_to', null)
                ->whereNotIn('id', $finished_auctions_favourites_ids)
                ->whereBetween('end_date', [$till_date, $now])
                ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get();
            if ($all_finished_favourites) {
                foreach ($all_finished_favourites as $item) {
                    $watchlist_item= CustomerAuction::where('auction_id', $item->id)->first();
                    if($watchlist_item) $watchlist_item->delete();
                };
            }
        }

        $sold_auctions_favourites_ids = [];

        $latest_ten_sold_favourites = Auction::whereHas('customer_auction_favourites',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id]);
            })
            ->whereNotNull('sold_to')
            ->whereBetween('end_date', [$till_date, $now])
            ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get()->take(10);
        if ($latest_ten_sold_favourites) {
            foreach ($latest_ten_sold_favourites as $item) $sold_auctions_favourites_ids[] = $item->id;
            $all_sold_favourites = Auction::whereHas('customer_auction_favourites',function($q) use ($user_id) {
                $q->where(['status' => CustomerAuction::$favourite, 'customer_id' => $user_id]);
            })
                ->whereNotNull('sold_to')
                ->whereNotIn('id', $sold_auctions_favourites_ids)
                ->whereBetween('end_date', [$till_date, $now])
                ->orderBy('end_date', 'desc')->orderBy('domain', 'asc')->get();
            if ($all_sold_favourites) {
                foreach ($all_sold_favourites as $item) {
                    $watchlist_item = CustomerAuction::where('auction_id', $item->id)->first();
                    if($watchlist_item) $watchlist_item->delete();

                };
            }
        }
    }
}
