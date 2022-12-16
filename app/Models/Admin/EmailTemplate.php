<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'template_name',
        'sender_name',
        'sender_email',
        'bcc',
        'email_subject',
        'email_text',
        'default',
        'type',
        'tags',
        'lang',
    ];

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }




}
