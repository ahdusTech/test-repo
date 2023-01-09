<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VersionPhoto extends Model
{

    protected $fillable = [
        'price',
        'WatermMarked_image',
        'status',
        'small_thumbnail',
        'singleImage',
        'original_image',
        'description',
        'photo_id',
        'Edit_original_image',
        'image_name',
        'counter',
        'color',

    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id', 'id');
    }

    public static function deleteLogo($id)
    {
        return VersionPhoto::find($id)->delete();
    }
}
