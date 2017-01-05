<?php

namespace moum\Providers;

use Carbon\Carbon;
use moum\Models\Comment;
use moum\Policies\CommentPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'moum\Models' => 'moum\Policies\ModelPolicy',
            Comment::class => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();

        //注册路由
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(1));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(2));
        
    }
}
