@extends('layouts.app')

@section('content')
<div class="container">

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 class="mb-4">マイページ</h2>

    {{-- ▼ プロフィール情報 --}}
    <div class="card mb-4 p-4">
        <div class="d-flex align-items-center">

            {{-- アイコン --}}
            <img src="{{ $user->icon ? asset('storage/'.$user->icon) : asset('default-icon.png') }}"
                class="rounded-circle mr-3"
                width="80" height="80"
                style="object-fit: cover;">

            <div>
                <h4>{{ $user->name }}</h4>
                <p class="mb-1">{{ $user->email }}</p>
                <p class="text-muted">登録日：{{ $user->created_at->format('Y-m-d') }}</p>
            </div>

            <div class="ml-auto">
                <a href="{{ route('mypage.edit') }}" class="btn btn-primary">プロフィール編集</a>
            </div>

        </div>
    </div>

    {{-- ▼ 自分の投稿一覧 --}}
    <h4 class="mt-4 mb-3">自分の投稿</h4>

    {{-- ▽ ボタン統一用スタイル --}}
    <style>
        .post-btn-left a {
            width: 120px;
        }
        .post-btn-right button {
            width: 120px;
        }
    </style>

    <div class="row">
        @forelse ($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">

                    {{-- 投稿画像 --}}
                    @if ($post->image_path)
                        <img src="{{ asset('storage/'.$post->image_path) }}"
                             class="card-img-top"
                             style="object-fit: cover; height: 180px;">
                    @else
                        <img src="https://via.placeholder.com/300x180"
                             class="card-img-top">
                    @endif

                    <div class="card-body">
                        <h5>{{ $post->title }}</h5>
                        <p class="text-muted">{{ $post->created_at }}</p>
                        <p>{{ Str::limit($post->content, 60) }}</p>
                    </div>

                    {{-- ▼ ボタン（左：詳細＆編集 / 右：削除） --}}
                    <div class="card-footer d-flex justify-content-between align-items-center">

                        {{-- 左側ボタン --}}
                        <div class="post-btn-left d-flex">
                            <a href="{{ route('posts.show', $post->id) }}"
                               class="btn btn-info btn-sm mr-2">
                                詳細
                            </a>

                            <a href="{{ route('posts.edit', $post->id) }}"
                               class="btn btn-success btn-sm">
                                編集
                            </a>
                        </div>

                        {{-- 右側ボタン（削除） --}}
                        <div class="post-btn-right">
                            <form action="{{ route('posts.destroy', $post->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    削除
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        @empty
            <p class="text-muted">投稿がありません。</p>
        @endforelse
    </div>

</div>
@endsection
