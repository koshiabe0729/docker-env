@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">ユーザー詳細</h3>

    <div class="card p-4">

        <p><strong>ID：</strong> {{ $user->id }}</p>
        <p><strong>名前：</strong> {{ $user->name }}</p>
        <p><strong>メール：</strong> {{ $user->email }}</p>
        <p><strong>登録日：</strong> {{ $user->created_at->format('Y-m-d') }}</p>
        <p><strong>権限：</strong> {{ $user->role == 1 ? '管理者' : '一般' }}</p>

    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
        戻る
    </a>

</div>
@endsection
