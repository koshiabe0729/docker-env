<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path',
        'is_hidden',
    ];

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // いいね
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 違反報告
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // コメント数
    public function getCommentCountAttribute()
    {
        return $this->comments()->count();
    }

    // いいね数
    public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }
}
