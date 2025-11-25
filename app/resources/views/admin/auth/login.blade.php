@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px;">

    <h3 class="mb-4 text-center">管理者ログイン</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" class="form-control" name="email" required autofocus>
        </div>

        <div class="form-group mt-3">
            <label>パスワード</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4">ログイン</button>
    </form>
</div>
@endsection
