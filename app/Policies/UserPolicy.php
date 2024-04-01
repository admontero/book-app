<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo(PermissionEnum::VER_USUARIOS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo(PermissionEnum::VER_USUARIOS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can assign permissions to the model.
     */
    public function assignRole(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo(PermissionEnum::ASIGNAR_ROLES_A_USUARIOS->value);
    }

    /**
     * Determine whether the user can assign permissions to the model.
     */
    public function assignPermission(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo(PermissionEnum::ASIGNAR_PERMISOS_A_USUARIOS->value);
    }
}
