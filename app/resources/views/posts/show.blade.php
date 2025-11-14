@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('home') }}" class="btn btn-secondary mb-3">← 一覧に戻る</a>

    <div class="card mb-4 shadow-sm">
        {{-- 画像がある場合 --}}
        @if($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}"
                 alt="投稿画像"
                 class="card-img-top"
                 style="max-height: 350px; object-fit: cover;">
        @endif

        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>

            <p class="text-muted">
                投稿者：{{ $post->user->name }}
                <br>
                投稿日時：{{ $post->created_at->format('Y-m-d H:i') }}
            </p>

            <p class="card-text" style="white-space: pre-line;">
                {{ $post->content }}
            </p>

            {{-- 編集・削除ボタン（投稿者本人のみ表示） --}}
            @if(Auth::id() === $post->user_id)
                <div class="mt-4">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集</a>

                    <form action="{{ route('posts.destroy', $post->id) }}"
                          method="POST"
                          style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('本当に削除しますか？')">
                            削除
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
