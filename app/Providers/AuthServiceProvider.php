<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //دالتين للتحق من حالة المستخدم عند الدخول للصفحة
        Gate::define('update-books', function ($user){
            return $user->isAdmin();
        });

        Gate::define('update-users',function ($user){
           return $user->isSuperAdmin();
        });
    }
}
