<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        $recent = Post::where('status', 1)->orderBy('created_at', 'asc')->limit(5)->get();
        return view('site.home', compact('recent'));
    }
}
