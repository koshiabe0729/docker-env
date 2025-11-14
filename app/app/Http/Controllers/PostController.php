<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostController extends Controller
{
    // ▼ 投稿一覧（検索機能つき）
    public function index(Request $request)
    {
        // キーワードを取得
        $keyword = $request->input('keyword');

        // クエリ作成
        $query = Post::query();

        // キーワード検索
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        // 最新順 & ページネーション
        $posts = $query->latest()->paginate(9);

        // Blade に posts と keyword を渡す
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

        // 画像がある場合は保存
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
        }

        // データ保存
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

        // 画像差し替え
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
            $post->image_path = $path;
        }

        // 内容更新
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
