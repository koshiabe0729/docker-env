<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 投稿一覧（最新順）
        $posts = Post::latest()->paginate(10);

        return view('home', compact('posts'));
    }
}
