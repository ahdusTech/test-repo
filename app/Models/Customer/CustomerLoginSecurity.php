<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerLoginSecurity extends Model
{
    protected $fillable = [
        'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
