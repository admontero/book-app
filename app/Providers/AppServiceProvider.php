<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        Gate::define('access-backoffice', function (User $user) {
            return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::SECRETARIO->value]);
        });

        Gate::define('access-frontoffice', function (User $user) {
            return $user->hasRole(RoleEnum::LECTOR->value);
        });

        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }
}
