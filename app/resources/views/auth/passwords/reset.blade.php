@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px;">

    <h3 class="text-center mb-4">パスワード再設定</h3>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 成功メッセージ --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- ▼ パスワード再設定フォーム --}}
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- リセット用トークン --}}
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- メールアドレス --}}
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

        {{-- 1. 新しいパスワード入力 --}}
        <div class="form-group">
            <label>新しいパスワード</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
                placeholder="新しいパスワードを入力"
            >
        </div>

        {{-- 2. 新しいパスワード再度入力 --}}
        <div class="form-group mt-3">
            <label>新しいパスワード（確認用）</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                placeholder="もう一度入力してください"
            >
        </div>

        {{-- 3. 登録ボタン --}}
        <button type="submit" class="btn btn-primary w-100 mt-4">
            登録
        </button>
    </form>
</div>
@endsection
