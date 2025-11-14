@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">新規投稿</h2>

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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- タイトル --}}
        <div class="form-group mb-3">
            <label>タイトル</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        {{-- 内容 --}}
        <div class="form-group mb-3">
            <label>内容</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        {{-- 画像アップロード --}}
        <div class="form-group mb-3">
            <label>画像（任意）</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">投稿する</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">戻る</a>
    </form>

</div>
@endsection
