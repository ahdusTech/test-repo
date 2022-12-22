<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CommonSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
}
