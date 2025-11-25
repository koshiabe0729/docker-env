<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 一般ユーザー認証ルート
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| トップ → /home にリダイレクト
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('home');
});


/*
|--------------------------------------------------------------------------
| 一般ユーザー専用（ログイン必須）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ▼ ホーム（投稿一覧）
    Route::get('/home', 'PostController@index')->name('home');

    // ▼ マイページ
    Route::get('/mypage', 'UserController@mypage')->name('mypage');
    Route::get('/mypage/edit', 'UserController@edit')->name('mypage.edit');
    Route::post('/mypage/update', 'UserController@update')->name('mypage.update');
    Route::delete('/mypage/delete', 'UserController@destroy')->name('mypage.delete');

    // ▼ 投稿 CRUD
    Route::resource('posts', 'PostController');

    // ▼ コメント
    Route::post('/comment/store', 'CommentController@store')->name('comment.store');
    Route::delete('/comment/{id}', 'CommentController@destroy')->name('comment.destroy');

    // ▼ いいね（Ajax）
    Route::post('/like', 'LikeController@like')->name('like');
    Route::post('/unlike', 'LikeController@unlike')->name('unlike');

    // ▼ 違反報告
    Route::post('/report', 'ReportController@store')->name('report.store');

    // パスワード再設定完了画面
    Route::get('/password/reset/complete', function () {
        return view('auth.passwords.pwd_comp');
    })->name('password.reset.complete');

});


/*
|--------------------------------------------------------------------------
| 管理者ログイン（一般ユーザーとは完全に分離）
| ※ここは auth ミドルウェア禁止
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ▼ 管理者ログイン画面
    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');

    // ▼ 管理者ログイン処理
    Route::post('/login', 'Admin\Auth\LoginController@login')->name('login.post');

    // ▼ 管理者ログアウト
    Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');
});


Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'can:admin'])
    ->group(function () {

        Route::get('/top', 'Admin\AdminTopController@index')->name('top');

        Route::get('/posts/search', 'Admin\PostController@search')->name('posts.search');

        Route::resource('posts', 'Admin\PostController');

        // 公開 / 非公開切替
        Route::post('/posts/{id}/toggle', 'Admin\PostController@toggle')
            ->name('posts.toggle');

        Route::resource('users', 'Admin\UserController');

        // 表示・非表示切り替え
        Route::patch('/posts/{id}/toggle-hidden', 'Admin\PostController@toggleHidden')
            ->name('posts.toggleHidden');

    });
