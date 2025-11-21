<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 保存を許可するカラム
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'icon',      // ← アイコン画像を保存するために追加！
    ];

    /**
     * 隠すカラム（配列へ変換時）
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 日付型にするカラム
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*----------------------------------------
     *  ▼ リレーション
     *----------------------------------------*/

    // ▼ 投稿（1対多）
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // ▼ コメント（1対多）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ▼ いいね（1対多）
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // ▼ 違反報告（1対多）
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /*----------------------------------------
     *  ▼ アクセサ（任意）
     *----------------------------------------*/

    // アイコン画像URLを取得（なければデフォルト画像）
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }
        return 'https://via.placeholder.com/100';
    }
}
