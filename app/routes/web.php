<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PostController,
    CommentController,
    LikeController,
    ReportController,
    UserController,
    AdminController
};

Auth::routes();

// 一般ユーザー
Route::get('/', [PostController::class, 'index'])->name('post.index');

Route::middleware('auth')->group(function () {
    // 投稿
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::post('/post/confirm', [PostController::class, 'confirm'])->name('post.confirm');
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');

    // コメント
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');

    // いいね
    Route::post('/post/{post}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/post/{post}/like', [LikeController::class, 'destroy'])->name('like.delete');
    Route::get('/likes', [LikeController::class, 'index'])->name('like.index');

    // 通報
    Route::post('/post/{post}/report', [ReportController::class, 'store'])->name('report.store');

    // ユーザー
    Route::get('/mypage', [UserController::class, 'mypage'])->name('user.mypage');
    Route::get('/mypage/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/mypage', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
});

// 管理者
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts');
    Route::delete('/admin/post/{post}', [AdminController::class, 'destroyPost'])->name('admin.post.delete');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/user/{user}', [AdminController::class, 'destroyUser'])->name('admin.user.delete');
});
