<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'reason',
        'details'
    ];

    // 報告したユーザー
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
