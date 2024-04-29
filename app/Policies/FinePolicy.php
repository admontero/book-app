<?php

namespace App\Policies;

use App\Enums\FineStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Fine;
use App\Models\User;

class FinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_MULTAS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fine $fine): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_MULTAS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_MULTAS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fine $fine): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_MULTAS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fine $fine): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fine $fine): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fine $fine): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the status.
     */
    public function updateStatus(User $user, Fine $fine): bool
    {
        return ($user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::EDITAR_ESTADO_MULTAS->value)) &&
            $fine->loan->status === LoanStatusEnum::COMPLETADO->value && $fine->status == FineStatusEnum::PENDIENTE->value;
    }
}
