<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyVisit extends Model
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'day' => 'date',
    ];

    /**
     * Get the visit domain.
     */
    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }

    public function getVisitsAdominoComAttribute(){
        return ($this->total - $this->visits);
    }
}
