<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
        'status',
        'highlight'
    ];

    public function has_tag($tag_id)
    {
        $rows = TagPost::where([['tag_id', $tag_id], ['post_id', $this->id]])->get();

        return count($rows) > 0 ? true : false;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
