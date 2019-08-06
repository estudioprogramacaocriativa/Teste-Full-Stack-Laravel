<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use App\TagPost;
use App\Post;

class PostsController extends Controller
{
    public function list()
    {
        $posts = Post::all();
        $collection = collect();

        foreach ($posts as $post):
            $tags = TagPost::where('post_id', $post->id)->join('tags', 'tag_post.tag_id', '=', 'tags.id')->get();
            $post->tags = $tags->pluck('name');
            $collection->push($post);
        endforeach;

        return PostResource::collection($collection);
    }

    public function show($name)
    {
        $post = Post::where('friendly_url', $name)->first();
        $tags = $post->tags;
        $post->tags = $tags->pluck('name');

        return new PostResource($post);
    }
}
