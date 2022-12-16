<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuctionEmailLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'auction_id',
        'current_auction_price',
    ];
}
