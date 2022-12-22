<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerLogin extends Model
{
    protected $fillable = [
        'customer_id',
        'last_login',
    ];
}
