<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostController extends Controller
{
    // ▼ 投稿一覧（公開投稿のみ & 検索対応 完全版）
    public function index(Request $request)
    {
        // キーワード取得
        $keyword = $request->input('keyword');

        // 公開投稿のみ（is_hidden = 0）
        $query = Post::where('is_hidden', 0)
            ->with(['comments.user']);

        // キーワード検索
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // 新着順 9 件ずつ
        $posts = $query->latest()->paginate(9);

        return view('home', compact('posts', 'keyword'));
    }


    // ▼ 投稿フォーム表示
    public function create()
    {
        return view('posts.create');
    }


    // ▼ 投稿保存
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:100',
            'content' => 'required',
            'image'   => 'image|nullable',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
        }

        Post::create([
            'user_id'    => Auth::id(),
            'title'      => $request->title,
            'content'    => $request->content,
            'image_path' => $path,
            'is_hidden'  => 0,
        ]);

        return redirect()->route('home')
                         ->with('success', '投稿が完了しました！');
    }


    // ▼ 詳細ページ
    public function show($id)
    {
        $post = Post::findOrFail($id);

        // 公開投稿のみ閲覧可
        if ($post->is_hidden == 1 && $post->user_id !== Auth::id()) {
            abort(403, 'この投稿は非公開です');
        }

        return view('posts.show', compact('post'));
    }


    // ▼ 編集フォーム表示
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, '権限がありません');
        }

        return view('posts.edit', compact('post'));
    }


    // ▼ 更新処理
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, '権限がありません');
        }

        $request->validate([
            'title'   => 'required|max:100',
            'content' => 'required',
            'image'   => 'image|nullable',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
            $post->image_path = $path;
        }

        $post->title   = $request->title;
        $post->content = $request->content;

        $post->save();

        return redirect()->route('posts.show', $post->id)
                         ->with('success', '投稿を更新しました！');
    }


    // ▼ 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, '権限がありません');
        }

        $post->delete();

        return redirect()->route('home')
                         ->with('success', '投稿を削除しました！');
    }
}
