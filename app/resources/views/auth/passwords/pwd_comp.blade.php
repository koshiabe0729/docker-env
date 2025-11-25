@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px;">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h3 class="mb-4">パスワード再設定完了</h3>

            <p class="mb-4">
                パスワードの再設定が完了しました。
            </p>

            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                ログイン画面へ
            </a>

        </div>
    </div>

</div>
@endsection
