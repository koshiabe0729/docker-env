<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * 管理者：投稿一覧（検索対応）
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Post::with('user')->orderBy('created_at', 'desc');

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('user', function ($uq) use ($keyword) {
                      $uq->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $posts = $query->paginate(20);

        return view('admin.posts.index', compact('posts', 'keyword'));
    }


    /**
     * 管理者：投稿詳細
     */
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }


    /**
     * 管理者：投稿削除
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', '投稿を削除しました。');
    }


    /**
     * 管理者：表示 / 非表示 切り替え
     */
    public function toggleHidden($id)
    {
        $post = Post::findOrFail($id);

        // 0 → 1, 1 → 0 に反転
        $post->is_hidden = $post->is_hidden ? 0 : 1;
        $post->save();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', '投稿の表示状態を変更しました。');
    }
}
