@extends('layouts.app')

@section('content')
<div class="container">

    {{-- 上部プロフィールエリア --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">

            {{-- アイコン（仮）--}}
            <div class="mr-4">
                <img src="https://via.placeholder.com/100"
                     alt="プロフィール画像"
                     class="rounded-circle"
                     width="100"
                     height="100">
            </div>

            {{-- ユーザー情報 --}}
            <div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-1">メール：{{ $user->email }}</p>
                <p class="text-muted">登録日：{{ $user->created_at->format('Y-m-d') }}</p>

              <a href="{{ route('mypage.edit') }}" class="btn btn-outline-primary btn-sm">
    プロフィール編集
              </a>

            </div>

        </div>
    </div>

    {{-- 投稿一覧 --}}
    <h4 class="mb-3">あなたの投稿</h4>

    @if ($posts->isEmpty())
        <p class="text-muted">投稿はまだありません。</p>
    @else
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

                            {{-- タイトル --}}
                            <h5 class="card-title">{{ $post->title }}</h5>

                            {{-- 本文（短縮） --}}
                            <p class="card-text">{{ Str::limit($post->content, 80) }}</p>

                            {{-- 投稿日時 --}}
                            <p class="text-muted" style="font-size: 0.85rem;">
                                投稿日時：{{ $post->created_at->format('Y-m-d H:i') }}
                            </p>

                            {{-- 詳細ボタン --}}
                            <a href="{{ route('posts.show', $post->id) }}"
                               class="btn btn-primary btn-sm">詳細</a>

                            {{-- 編集・削除 --}}
                            <a href="{{ route('posts.edit', $post->id) }}"
                               class="btn btn-outline-primary btn-sm">編集</a>

                            <form action="{{ route('posts.destroy', $post->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('投稿を削除しますか？');">
                                    削除
                                </button>
                            </form>

                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
