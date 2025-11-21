<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comment_text',
    ];

    // コメントしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 対象の投稿
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
