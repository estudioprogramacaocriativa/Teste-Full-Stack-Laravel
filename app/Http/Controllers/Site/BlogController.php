<?php

namespace App\Http\Controllers\Site;

use App\Post;
use App\TagPost;
use App\Http\Controllers\Controller;
use App\Helpers\FileManager;

class BlogController extends Controller
{
    public function show($name)
    {
        $recent = Post::where('status', 1)->orderBy('created_at', 'asc')->limit(5)->get();
        $post = Post::where('friendly_url', $name)->first();
        $post->image = FileManager::get($post->image, "posts/{$post->id}", ['tim' => ['w' => 1200, 'h' => 400]]);
        $post->author = $post->author;
        $tags = TagPost::where('post_id', $post->id)->join('tags', 'tag_post.tag_id', '=', 'tags.id')->get();
        $post->tags = $tags->pluck('name');

        return view('site.blog-single', compact('post', 'recent'));
    }
}
