<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// ログイン後のメインページ（投稿一覧）
Route::get('/home', 'PostController@index')->name('home')->middleware('auth');

// 投稿 CRUD ルート
Route::resource('posts', 'PostController')->middleware('auth');
