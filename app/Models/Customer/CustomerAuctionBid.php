<?php

namespace App\Models\Customer;

use App\Models\Admin\Auction;
use Illuminate\Database\Eloquent\Model;

class CustomerAuctionBid extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_auction_id',
        'auction_id',
        'bid_type',
        'current_price',
        'bid_price',
    ];

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
