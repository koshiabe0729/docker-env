<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 管理者
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        // 一般ユーザ
        User::create([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role' => 0,
        ]);
    }
}
