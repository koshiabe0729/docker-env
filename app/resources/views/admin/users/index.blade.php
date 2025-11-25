@extends('layouts.app')

@section('content')
<div class="container">

    {{-- タイトル --}}
    <h3 class="mb-4">ユーザー管理</h3>

    {{-- 検索フォーム --}}
    <div class="card mb-4 p-3">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="form-row">

                {{-- キーワード入力 --}}
                <div class="col-md-8">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="ユーザー名 / メールアドレスで検索"
                           value="{{ request('keyword') }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        検索
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- 検索結果 --}}
    <div class="card p-3">
        <h5 class="mb-3">検索結果（{{ $users->count() }} 件）</h5>

        @if($users->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>登録日</th>
                    <th style="width:120px;">詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="btn btn-info btn-sm w-100">
                           詳細
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーション --}}
        {{ $users->appends(['keyword' => request('keyword')])->links() }}

        @else
            <p class="text-muted">検索結果はありません。</p>
        @endif

    </div>
</div>
@endsection
