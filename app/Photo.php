<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = [

        'price',
        'image',
        'status',
        'small_thumbnail',
        'singleImage',
        'original_image',
        'description',
        'sub_category_id',
        'category_id',
        'originalResized',
        'color',
        'image_name',
        'counter',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public static function deleteLogo($id)
    {
        return Photo::find($id)->delete();
    }
}
