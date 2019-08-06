<?php

namespace App\Http\Controllers;

use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        $published = Post::where('status', 1)->get()->count();
        $draft = Post::where('status', 0)->get()->count();

        return view('home', compact('published', 'draft'));
    }
}
