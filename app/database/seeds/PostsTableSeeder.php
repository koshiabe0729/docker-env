<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // 管理者投稿
        Post::create([
            'user_id'     => 1,
            'title'       => '管理者の投稿',
            'content'     => '管理者のサンプル投稿です。',
            'image_path'  => null,
            'is_hidden'   => 0,
            'updated_at'  => now(),
        ]);

        // 一般ユーザ投稿
        Post::create([
            'user_id'     => 2,
            'title'       => '一般ユーザの投稿',
            'content'     => '一般ユーザの投稿です。横並び表示テスト。',
            'image_path'  => null,
            'is_hidden'   => 0,
            'updated_at'  => now(),
        ]);

        // 横並びテスト用（6件）
        for ($i = 1; $i <= 6; $i++) {
            Post::create([
                'user_id'     => ($i % 2) + 1,
                'title'       => "テスト投稿 {$i}",
                'content'     => "横並びテスト投稿 No.{$i}。カード表示のデモテキストです。",
                'image_path'  => null,
                'is_hidden'   => 0,
                'updated_at'  => now(),
            ]);
        }
    }
}
