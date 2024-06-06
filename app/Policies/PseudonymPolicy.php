<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Pseudonym;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PseudonymPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_PSEUDONIMOS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pseudonym $pseudonym): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_PSEUDONIMOS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::CREAR_PSEUDONIMOS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pseudonym $pseudonym): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::EDITAR_PSEUDONIMOS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pseudonym $pseudonym): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pseudonym $pseudonym): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pseudonym $pseudonym): bool
    {
        return false;
    }
}
