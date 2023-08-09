<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-dashboard', function ($admin) {
            // Add your logic here to check if the admin can access the dashboard
            // For example, allow all admins to access the dashboard:
            // return true;
            return $admin->hasPermissionTo('access-dashboard');
        });
        Gate::define('view-dashboard', function ($employee) {
            // Add your logic here to check if the admin can access the dashboard
            // For example, allow all admins to access the dashboard:
            // return true;
            return $employee->hasPermissionTo('access-dashboard');
        });
    }
}
