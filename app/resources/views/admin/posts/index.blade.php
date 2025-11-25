@extends('Layouts.app') {{-- 管理者用レイアウトに合わせて変更してください --}}

@section('content')
<div class="container">

    <h2 class="mb-4">管理者：投稿管理</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ▼ 検索フォーム --}}
    <form action="{{ route('admin.posts.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="タイトル / 内容 / 投稿者名"
                   value="{{ $keyword ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn-primary">検索</button>
            </div>
        </div>
    </form>

    {{-- ▼ 投稿一覧 --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>投稿者</th>
                <th>タイトル</th>
                <th>作成日</th>
                <th>状態</th>
                <th style="width:260px;">操作</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->created_at }}</td>

                {{-- 公開/非公開 --}}
                <td>
                    @if ($post->is_hidden)
                        <span class="badge bg-danger">非公開</span>
                    @else
                        <span class="badge bg-success">公開</span>
                    @endif
                </td>

                <td>

                    {{-- 詳細 --}}
                    <a href="{{ route('admin.posts.show', $post->id) }}"
                       class="btn btn-info btn-sm">詳細</a>

                    {{-- ▼ 表示／非表示 切り替え --}}
                    <form action="{{ route('admin.posts.toggleHidden', $post->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('PATCH')

                        @if($post->is_hidden)
                            <button class="btn btn-success btn-sm">表示にする</button>
                        @else
                            <button class="btn btn-warning btn-sm">非表示にする</button>
                        @endif
                    </form>

                    {{-- 削除 --}}
                    <form action="{{ route('admin.posts.destroy', $post->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">削除</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ▼ ページネーション --}}
    <div class="mt-3">
        {{ $posts->links() }}
    </div>

</div>
@endsection
