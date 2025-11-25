@extends('layouts.app')

@section('content')
<div class="container">

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-4">

        <h3>投稿一覧</h3>

        {{-- 上部メニュー --}}
        <div class="d-flex">

            {{-- マイページ --}}
            <a href="{{ route('mypage') }}" class="btn btn-outline-secondary mr-2">
                マイページ
            </a>

            {{-- 新規投稿 --}}
            <a href="{{ route('posts.create') }}" class="btn btn-primary mr-2">
                新規投稿
            </a>

            {{-- 退会 --}}
            <form action="{{ route('mypage.delete') }}"
                  method="POST"
                  onsubmit="return confirm('本当に退会しますか？');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">退会</button>
            </form>
        </div>
    </div>

    {{-- キーワード検索 --}}
    <form action="{{ route('home') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="キーワード検索"
                   value="{{ request('keyword') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary">検索</button>
            </div>
        </div>
    </form>

    {{-- 投稿一覧（公開投稿のみ） --}}
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    {{-- 投稿画像 --}}
                    @if ($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}"
                             class="card-img-top"
                             style="object-fit: cover; height: 200px;">
                    @else
                        <img src="https://via.placeholder.com/400x200"
                             class="card-img-top">
                    @endif

                    <div class="card-body">

                        <h5>{{ $post->title }}</h5>
                        <p>{{ Str::limit($post->content, 80) }}</p>

                        {{-- 詳細 --}}
                        <a href="{{ route('posts.show', $post->id) }}"
                           class="btn btn-primary btn-sm">詳細</a>

                        <hr>

                        {{-- コメント一覧 --}}
                        <h6>コメント（{{ $post->comments->count() }}件）</h6>

                        @forelse ($post->comments as $comment)
                            <div class="border rounded p-2 mb-2 bg-light">
                                <strong>{{ $comment->user->name }}</strong><br>
                                {{ $comment->comment_text }}
                            </div>
                        @empty
                            <p class="text-muted">コメントなし</p>
                        @endforelse

                        {{-- コメント投稿フォーム --}}
                        <form action="{{ route('comment.store') }}"
                              method="POST"
                              class="mt-2">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                            <textarea name="comment_text"
                                      class="form-control mb-2"
                                      rows="2"
                                      placeholder="コメントを書く…"></textarea>

                            <button type="submit" class="btn btn-success btn-sm">
                                コメントする
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    <div class="mt-3">
        {{ $posts->links() }}
    </div>

</div>
@endsection
