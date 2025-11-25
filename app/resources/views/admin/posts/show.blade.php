@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">【管理者】投稿詳細</h2>

    <div class="card mb-4">
        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}"
                 class="card-img-top"
                 style="object-fit: cover; height: 300px;">
        @endif

        <div class="card-body">
            <h4>{{ $post->title }}</h4>

            <p class="text-muted">
                投稿者：{{ $post->user->name }}<br>
                投稿日時：{{ $post->created_at->format('Y-m-d H:i') }}
            </p>

            <hr>

            <p style="white-space: pre-wrap; font-size:16px;">
                {{ $post->content }}
            </p>
        </div>
    </div>

    <a href="{{ route('admin.posts.edit', $post->id) }}"
       class="btn btn-success">編集</a>

    <form action="{{ route('admin.posts.destroy', $post->id) }}"
          method="POST" class="d-inline"
          onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">削除</button>
    </form>

    <a href="{{ route('admin.posts.index') }}"
       class="btn btn-secondary ml-3">一覧へ戻る</a>

</div>
@endsection
