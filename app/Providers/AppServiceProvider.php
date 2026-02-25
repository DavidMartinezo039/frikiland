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
        // Esto verifica si tiene el rol a través de la tabla de relaciones de Spatie
        return $user->hasRole('seller') || $user->hasRole('admin');
    });
    }
}
