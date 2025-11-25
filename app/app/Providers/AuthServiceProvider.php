<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
        |--------------------------------------------------------------------------
        | 管理者権限（role=1）の判定
        |--------------------------------------------------------------------------
        |
        | ここで、ユーザーが管理者かどうか判断します。
        | role が 1 のユーザーだけが管理者ページにアクセスできます。
        |
        */

        Gate::define('admin', function (User $user) {
            return $user->role === 1;
        });
    }
}
