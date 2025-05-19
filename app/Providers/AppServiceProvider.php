<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Botiga; 

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
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('access-editor', function ($user) {
            return $user->role === 'editor';
        });
        
        Gate::define('edit-botiga', function ($user, Botiga $botiga) {
            return $user->role === 'editor' && $user->id === $botiga->user_id;
        });
    }
}
