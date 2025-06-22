<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('is-receptionist', function ($user) {
            return $user->role === 'receptionist';
        });

        Gate::define('is-cashier', function ($user) {
            return $user->role === 'cashier';
        });

        Gate::define('is-service-staff', function ($user) {
            return $user->role === 'service_staff';
        });

        Gate::define('is-doctor', function ($user) {
            return $user->role === 'doctor';
        });

        Gate::define('is-pharmacist', function ($user) {
            return $user->role === 'pharmacist';
        });

        Gate::define('is-inpatient-manager', function ($user) {
            return $user->role === 'inpatient_manager';
        });

        Gate::define('is-hr-manager', function ($user) {
            return $user->role === 'hr_manager';
        });

        Gate::define('is-patient', function ($user) {
            return $user->role === 'patient';
        });
    }
}
