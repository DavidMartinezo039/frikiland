<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        Gate::define('is-seller', function (User $user) {
        // Opción A: Si tienes una columna 'role' en tu tabla users
        return $user->role === 'seller' || $user->roles === 'admin';

        // Opción B: Si usas el paquete Spatie Roles & Permissions
        // return $user->hasRole('seller');
    });
    }
}
