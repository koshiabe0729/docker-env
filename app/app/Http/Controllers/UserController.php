<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class UserController extends Controller
{
    // ▼ マイページ表示
    public function mypage()
    {
        $user = Auth::user();

        $posts = $user->posts()->latest()->get();
        $comments = $user->comments()->latest()->get();
        $likedPosts = Post::whereIn('id', $user->likes()->pluck('post_id'))
                          ->latest()
                          ->get();

        return view('mypage.index', compact('user', 'posts', 'comments', 'likedPosts'));
    }

    // ▼ 編集表示
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.edit', compact('user'));
    }

    // ▼ 更新処理
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:50',
            'email' => 'required|email',
            'icon'  => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $user->icon = $path;
        }

        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました！');
    }

    // ▼ 退会処理
    public function destroy()
    {
        $user = Auth::user();

        // 関連データも削除
        $user->posts()->delete();
        $user->comments()->delete();
        $user->likes()->delete();
        $user->reports()->delete();

        // 自分自身を削除
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', '退会が完了しました。ご利用ありがとうございました。');
    }
}
