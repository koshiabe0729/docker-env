@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h2>投稿一覧</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">新規投稿</a>
    </div>

    {{-- 🔍 検索フォーム --}}
    <form action="{{ route('home') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="keyword"
                   placeholder="キーワード検索"
                   class="form-control"
                   value="{{ $keyword ?? '' }}">
            <span class="input-group-btn">
                <button class="btn btn-outline-secondary" type="submit">検索</button>
            </span>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ▼ ここからカード表示（3列） --}}
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">

                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body">
                        <h5>{{ Str::limit($post->title, 20) }}</h5>
                        <p>{{ Str::limit($post->content, 80) }}</p>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">詳細</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    <div class="d-flex justify-content-center">
        {{ $posts->appends(['keyword' => $keyword])->links() }}
    </div>

</div>
@endsection
