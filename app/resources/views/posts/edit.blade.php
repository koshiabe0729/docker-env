@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">投稿編集</h2>

    {{-- エラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- タイトル --}}
        <div class="form-group mb-3">
            <label>タイトル</label>
            <input type="text" name="title" value="{{ $post->title }}" class="form-control" required>
        </div>

        {{-- 内容 --}}
        <div class="form-group mb-3">
            <label>内容</label>
            <textarea name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>

        {{-- 現在の画像 --}}
        @if ($post->image_path)
            <div class="mb-3">
                <p>現在の画像：</p>
                <img src="{{ asset('storage/' . $post->image_path) }}" style="max-width: 300px;">
            </div>
        @endif

        {{-- 新しい画像 --}}
        <div class="form-group mb-3">
            <label>画像を変更（任意）</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">戻る</a>
    </form>

</div>
@endsection
