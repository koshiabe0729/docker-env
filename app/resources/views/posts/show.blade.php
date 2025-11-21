@extends('layouts.app')

@section('content')
<div class="container">

    {{-- 戻る --}}
    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">← 一覧に戻る</a>

    <div class="card mb-4">

        {{-- 投稿画像 --}}
        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}"
                 style="object-fit:cover; width:100%; height:350px;">
        @endif

        <div class="card-body">
            <h3>{{ $post->title }}</h3>

            <p class="text-muted mb-1">投稿者：{{ $post->user->name }}</p>
            <p class="text-muted">投稿日時：{{ $post->created_at }}</p>

            <p class="mt-3">{{ $post->content }}</p>

            <hr>

            {{-- ▼ 編集 & 削除 & いいね & 違反報告 --}}
            <div class="d-flex justify-content-between align-items-center">

                {{-- 左：編集 / 削除 --}}
                <div>
                    @if (Auth::id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">編集</a>

                        <form action="{{ route('posts.destroy', $post->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">削除</button>
                        </form>
                    @endif
                </div>

                {{-- 右：いいね ＋ 通報 --}}
                <div class="d-flex gap-2 align-items-center">

                    {{-- いいね数 --}}
                    <span id="likes-count-{{ $post->id }}" class="mr-2">
                        {{ $post->likes->count() }}
                    </span>

                    {{-- いいね状態 --}}
                    @php
                        $alreadyLiked = $post->likes->where('user_id', Auth::id())->count() > 0;
                    @endphp

                    <button
                        class="btn btn-sm like-btn
                            {{ $alreadyLiked ? 'btn-danger' : 'btn-primary' }}"
                        data-post-id="{{ $post->id }}"
                        data-liked="{{ $alreadyLiked ? 1 : 0 }}"
                    >
                        {{ $alreadyLiked ? 'いいね解除' : 'いいね' }}
                    </button>

                    {{-- ▼ 違反報告 --}}
                    <form action="{{ route('report.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class="btn btn-warning btn-sm">🚨 違反報告</button>
                    </form>

                </div>

            </div>

        </div>
    </div>

    {{-- ▼ コメント欄 --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4>コメント（{{ $post->comments->count() }}件）</h4>

            @if ($post->comments->isEmpty())
                <p class="text-muted">コメントはまだありません</p>
            @else
                @foreach ($post->comments as $comment)
                    <div class="border rounded p-2 mb-2 bg-light">
                        <strong>{{ $comment->user->name }}</strong>
                        <p class="mb-1">{{ $comment->comment_text }}</p>
                        <small class="text-muted">{{ $comment->created_at }}</small>
                    </div>
                @endforeach
            @endif

            {{-- コメント投稿 --}}
            <form action="{{ route('comment.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="comment_text" class="form-control mb-2" rows="2"></textarea>
                <button class="btn btn-success btn-sm">コメントする</button>
            </form>

        </div>
    </div>

</div>
@endsection
