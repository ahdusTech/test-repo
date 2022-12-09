<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
         'updated_at',
    ];

    /**
     * Get the inquiry domain.
     */
    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }

    public static function deleteInquiry($id)
    {
        return Inquiry::withTrashed()->find($id)->delete();
    }

    public static function saveInquiry($inquiryArray)
    {
        if (isset($inquiryArray['id']))
            $inquiry = Inquiry::withTrashed()->find($inquiryArray['id']);
        else
            $inquiry = new Inquiry();
        foreach ($inquiryArray as $inquiry_col => $inquiry_val) {
            if ($inquiry_col == 'created_at')
                $inquiry->$inquiry_col = Carbon::parse($inquiry_val);
            else
                $inquiry->$inquiry_col = $inquiry_val;
        }
        $inquiry->save();
    }

    public static function anonymousInquiry($id)
    {
        $inquiry = Inquiry::withTrashed()->find($id);
        if (isset($inquiry->id) && !empty($inquiry->id)) {
            $inquiry->prename = !$inquiry->prename ?: str_replace(substr($inquiry->prename, '2'), str_repeat('*', strlen($inquiry->prename) - 2), $inquiry->prename);
            $inquiry->surname = str_replace(substr($inquiry->surname, '2'), str_repeat('*', strlen($inquiry->surname) - 2), $inquiry->surname);
            $inquiry->email = str_replace(substr($inquiry->email, '2'), str_repeat('*', strlen($inquiry->email) - 2), $inquiry->email);
            $inquiry->ip = !$inquiry->ip ?: str_replace(substr($inquiry->ip, '2'), str_repeat('*', strlen($inquiry->ip) - 2), $inquiry->ip);
            $inquiry->save();
            $inquiry->delete();
        }
    }

    public static function getInquiry($id)
    {
        return Inquiry::withTrashed()->find($id);
    }
}
