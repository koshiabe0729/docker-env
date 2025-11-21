@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">管理者：投稿一覧</h2>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>作成者</th>
                <th>作成日</th>
                <th>操作</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->user_name ?? '不明' }}</td>
                    <td>{{ $post->created_at->format('Y-m-d') }}</td>

                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">編集</a>

                        {{-- 削除 --}}
                        <form action="{{ route('posts.destroy', $post->id) }}"
                              method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('削除しますか？')">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- ページネーション --}}
    <div class="mt-3">
        {{ $posts->links() }}
    </div>

</div>
@endsection
