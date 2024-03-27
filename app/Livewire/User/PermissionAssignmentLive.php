<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionAssignmentLive extends Component
{
    public User $user;

    public array $permissions = [];

    public bool $selectedAll = false;

    public function mount(): void
    {
        $this->user->load('permissions');

        $this->loadPermissions();

        $this->selectedAll = count($this->permissions) == count($this->allPermissionsId);
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            $this->permissions = array_values(array_unique([...$this->permissions, ...$this->allPermissionsId]));
        } else {
            $this->reset('permissions');
        }
    }

    #[Computed]
    public function allPermissionsId(): array
    {
        return Permission::pluck('id')->toArray();
    }

    #[Computed]
    public function permissionsViaRoles(): Collection
    {
        return $this->user->roles->flatMap(fn ($role) => $role->permissions)->pluck('id');
    }

    public function setSwitch(bool $value): void
    {
        $this->selectedAll = $value;
    }

    public function loadPermissions(): void
    {
        $this->reset('permissions');

        $this->permissions = array_unique([
            ...$this->permissions,
            ...$this->user->permissions->pluck('id')->toArray()
        ]);
    }

    public function save(): void
    {
        $this->user->syncPermissions(
            array_map('intval', $this->permissions)
        );

        $this->dispatch('saved')->self();
        $this->dispatch('new-alert', message: 'Permisos asignados con éxito', type: 'success');
    }

    public function render(): View
    {
        $allPermissionIds = Permission::orderBy('id')->pluck('id')->toArray();

        $allPermissions = Permission::select('id', 'name', 'description')->get();

        return view('livewire.user.permission-assignment-live', [
            'allPermissionIds' => $allPermissionIds,
            'allPermissions' => $allPermissions,
        ]);
    }
}
