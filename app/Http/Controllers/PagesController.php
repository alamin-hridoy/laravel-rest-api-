<?php

namespace Task\Http\Controllers;

use Illuminate\Http\Request;
use Task\Post;

class PagesController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->take(10)->get();
        return view('pages.index')->with('posts', $posts);
    }

    public function about() {
        return view('pages.about');
    }
}
