@extends('layouts.app')

@section('content')
<div class="container">

    {{-- タイトル --}}
    <h3 class="mb-4">管理ユーザー専用投稿検索</h3>

    {{-- 検索フォーム --}}
    <div class="card p-3 mb-4">
        <form action="{{ route('admin.posts.search') }}" method="GET" class="form-inline">

            <label class="mr-2">ユーザー名：</label>
            <input type="text" name="keyword" class="form-control mr-2"
                   placeholder="検索キーワード" value="{{ request('keyword') }}">

            <button class="btn btn-primary">検索</button>
        </form>
    </div>

    {{-- 投稿一覧 --}}
    <div class="card">
        <table class="table table-bordered mb-0">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>ユーザー名</th>
                    <th>タイトル</th>
                    <th>ステータス</th>
                    <th>投稿日時</th>
                    <th>詳細</th>
                </tr>
            </thead>

            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->title }}</td>

                        {{-- ステータスは is_hidden = 1 なら 非公開 --}}
                        <td>
                            @if($post->is_hidden)
                                <span class="badge badge-danger">非公開</span>
                            @else
                                <span class="badge badge-success">公開</span>
                            @endif
                        </td>

                        <td>{{ $post->created_at }}</td>

                        <td>
                            <a href="{{ route('admin.posts.show', $post->id) }}"
                               class="btn btn-info btn-sm">
                                詳細
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">データがありません</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- ページネーション --}}
        <div class="p-3">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection
