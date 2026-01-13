<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define admin gate for route authorization
        Gate::define('admin', function ($user) {
            return $user && isset($user->role) && $user->role === 'admin';
        });

        // Map standings model to its policy
        Gate::policy(\App\Models\standings::class, \App\Policies\StandingPolicy::class);
    }
}
