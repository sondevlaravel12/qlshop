<?php

namespace App\Providers;

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
        // tenancy()->hook('bootstrapped', function (TenantManager $tenantManager) {
        //     \Spatie\Permission\PermissionRegistrar::$cacheKey = 'spatie.permission.cache.tenant.' . $tenantManager->getTenant('id');
        // });
    }
}
