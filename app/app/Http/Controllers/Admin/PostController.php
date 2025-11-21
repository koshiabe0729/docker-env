<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * 管理者：投稿一覧
     */
    public function index()
    {
        $posts = Post::latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * 管理者：新規投稿作成フォーム
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * 管理者：投稿保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:100',
            'content' => 'required',
            'image'   => 'image|nullable'
        ]);

        // 画像保存
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
        }

        Post::create([
            'user_id'    => Auth::id(),    // 管理者のID
            'title'      => $request->title,
            'content'    => $request->content,
            'image_path' => $path,
            'is_hidden'  => 0,
        ]);

        return redirect()->route('posts.index')
                         ->with('success', '投稿を作成しました！');
    }

    /**
     * 管理者：投稿詳細
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * 管理者：編集フォーム
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * 管理者：投稿更新
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'   => 'required|max:100',
            'content' => 'required',
            'image'   => 'image|nullable'
        ]);

        // 画像差し替え
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
            $post->image_path = $path;
        }

        $post->title   = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('posts.index')
                         ->with('success', '投稿を更新しました！');
    }

    /**
     * 管理者：投稿削除
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('posts.index')
                         ->with('success', '投稿を削除しました！');
    }
}
