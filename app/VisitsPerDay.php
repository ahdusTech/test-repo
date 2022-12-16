<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitsPerDay extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the inquiry domain.
     */
    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }
}
