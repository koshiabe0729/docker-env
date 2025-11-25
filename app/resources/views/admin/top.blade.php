@extends('layouts.app')

@section('content')
<div class="container text-center">

    <h2 class="mb-5">管理者ページ</h2>

    <div class="d-flex flex-column align-items-center">

        {{-- ▼ ユーザー検索 --}}
        <a href="{{ route('admin.users.index') }}"
           class="btn btn-primary mb-4"
           style="width: 250px; padding: 15px; font-size: 18px;">
            1. ユーザー検索
        </a>

        {{-- ▼ 投稿検索 --}}
        <a href="{{ route('admin.posts.index') }}"
           class="btn btn-secondary"
           style="width: 250px; padding: 15px; font-size: 18px;">
            2. 投稿検索
        </a>

    </div>

</div>
@endsection
