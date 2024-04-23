<?php

namespace App\Policies;

use App\Enums\LoanStatusEnum;
use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_PRESTAMOS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::VER_PRESTAMOS->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::CREAR_PRESTAMOS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::EDITAR_PRESTAMOS->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Loan $loan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Loan $loan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the status.
     */
    public function updateStatus(User $user, Loan $loan): bool
    {
        return ($user->hasRole(RoleEnum::ADMIN->value) || $user->hasPermissionTo(PermissionEnum::EDITAR_ESTADO_PRESTAMOS->value)) &&
            $loan->status === LoanStatusEnum::EN_CURSO->value;
    }
}
