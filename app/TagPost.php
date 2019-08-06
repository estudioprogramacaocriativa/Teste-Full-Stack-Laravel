<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
    public $table = 'tag_post';

    public $timestamps = false;

    protected $fillable = [
        'tag_id',
        'post_id'
    ];
}
