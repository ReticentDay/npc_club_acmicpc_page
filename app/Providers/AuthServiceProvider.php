<?php

namespace App\Providers;

use App\Post;
use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('check_root', function ($user) {
            return $user->type === 'root';
        });

        Gate::define('check_admin', function ($user) {
            return $user->type === 'admin' ||  $user->type === 'root';
        });
        Gate::define('update', function ($user,$post) {
            return $user->id == $post->creat_user || $user->type === 'root';
        });
        Gate::define('updateName', function ($user,$post) {
            return $user->name == $post->creat_user || $user->type === 'root';
        });
        Gate::define('check_bucket', function ($user) {
            return $user->type === 'bucket' ||  $user->type === 'blockade';
        });
        Gate::define('check_blockade', function ($user) {
            return $user->type === 'blockade';
        });
    }
}
