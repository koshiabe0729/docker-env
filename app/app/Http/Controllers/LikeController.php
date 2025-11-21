<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $postId = $request->post_id;

        Like::firstOrCreate([
            'post_id' => $postId,
            'user_id' => Auth::id(),
        ]);

        $count = Like::where('post_id', $postId)->count();

        return response()->json([
            'likes_count' => $count
        ]);
    }

    public function unlike(Request $request)
    {
        $postId = $request->post_id;

        Like::where('post_id', $postId)
            ->where('user_id', Auth::id())
            ->delete();

        $count = Like::where('post_id', $postId)->count();

        return response()->json([
            'likes_count' => $count
        ]);
    }
}
