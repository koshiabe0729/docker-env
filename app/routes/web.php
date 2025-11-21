<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});

// ▼ 一般ユーザー：マイページ
Route::middleware('auth')->group(function () {

    // マイページ表示
    Route::get('/mypage', 'UserController@mypage')->name('mypage');

    // 編集フォーム
    Route::get('/mypage/edit', 'UserController@edit')->name('mypage.edit');

    // 更新処理
    Route::post('/mypage/update', 'UserController@update')->name('mypage.update');
});

// ▼ 投稿一覧（ホーム）
Route::get('/home', 'PostController@index')->name('home')->middleware('auth');

// ▼ 投稿 CRUD
Route::resource('posts', 'PostController')->middleware('auth');

// ▼ コメント
Route::post('/comment/store', 'CommentController@store')->name('comment.store')->middleware('auth');
Route::delete('/comment/{id}', 'CommentController@destroy')->name('comment.destroy')->middleware('auth');

// ▼ いいね（Ajax）
Route::post('/like', 'LikeController@like')->name('like')->middleware('auth');
Route::post('/unlike', 'LikeController@unlike')->name('unlike')->middleware('auth');

// ▼ 違反報告
Route::post('/report', 'ReportController@store')->name('report.store')->middleware('auth');

// ▼ 退会処理
Route::delete('/mypage/delete', 'UserController@destroy')
    ->name('mypage.delete')
    ->middleware('auth');

// ▼ 管理者用
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('users', 'Admin\UserController');
    Route::resource('posts', 'Admin\PostController');
});
