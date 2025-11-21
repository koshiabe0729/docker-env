@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">プロフィール編集</h3>

    <form action="{{ route('mypage.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- 名前 --}}
        <div class="form-group">
            <label>名前</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        {{-- メール --}}
        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $user->email) }}"
                   required>
        </div>

        {{-- アイコン --}}
        <div class="form-group">
            <label>現在のアイコン</label><br>
            @if ($user->icon)
                <img src="{{ asset('storage/' . $user->icon) }}"
                     style="width:80px; height:80px; object-fit:cover;"
                     class="rounded-circle mb-2">
            @else
                <p class="text-muted">未登録</p>
            @endif
        </div>

        <div class="form-group">
            <label>新しいアイコン（任意）</label>
            <input type="file" name="icon" class="form-control-file">
        </div>

        <button class="btn btn-primary mt-3">更新する</button>
        <a href="{{ route('mypage') }}" class="btn btn-secondary mt-3">戻る</a>

    </form>

</div>
@endsection
