@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">管理者：新規投稿作成</h2>

    {{-- ▼ バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ▼ 投稿作成フォーム --}}
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- タイトル --}}
        <div class="form-group mb-3">
            <label for="title">タイトル</label>
            <input type="text"
                   name="title"
                   id="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}"
                   required>
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- 内容 --}}
        <div class="form-group mb-3">
            <label for="content">内容</label>
            <textarea name="content"
                      id="content"
                      rows="5"
                      class="form-control @error('content') is-invalid @enderror"
                      required>{{ old('content') }}</textarea>
            @error('content')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- 画像 --}}
        <div class="form-group mb-3">
            <label for="image">画像（任意）</label>
            <input type="file"
                   name="image"
                   id="image"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/*"
                   onchange="previewImage(event)">
            @error('image')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror

            {{-- ▼ プレビュー --}}
            <div class="mt-3">
                <img id="preview" src="#" alt="プレビュー画像" style="display:none; max-width: 300px;">
            </div>
        </div>

        {{-- 送信ボタン --}}
        <button type="submit" class="btn btn-primary">投稿する</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>

{{-- ▼ 画像プレビュー用スクリプト --}}
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>

@endsection
