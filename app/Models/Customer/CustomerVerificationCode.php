<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerVerificationCode extends Model
{
    protected $fillable = [
        'email',
        'new_email',
        'phone_code',
        'phone_number',
        'verification_code',
        'expired_at',
    ];
}
