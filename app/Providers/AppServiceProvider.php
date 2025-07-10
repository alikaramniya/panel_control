<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        Gate::before(function (User $user, string $ability) {
            if ($user->role === 'super_admin') {
                return true;
            }
        });
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin() ? true : false;
        });

        Gate::define('canDeleteUser', function (User $user, User $currentUser) {
            if ($user->isAdmin() && !$currentUser->isAdmin()) {
                return true;
            }

            return false;
        });
    }
}
