<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionAssignmentLive extends Component
{
    public Role $role;

    public array $permissions = [];

    public bool $selectedAll = false;

    public function mount(): void
    {
        $this->role->load('permissions');

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

    public function setSwitch(bool $value): void
    {
        $this->selectedAll = $value;
    }

    public function loadPermissions(): void
    {
        $this->reset('permissions');

        $this->permissions = array_unique([
            ...$this->permissions,
            ...$this->role->permissions->pluck('id')->toArray()
        ]);
    }

    public function save(): void
    {
        $this->role->syncPermissions(
            array_map('intval', $this->permissions)
        );

        $this->dispatch('saved')->self();
        $this->dispatch('new-alert', message: 'Permisos asignados con éxito', type: 'success');
    }

    public function render()
    {
        $allPermissionIds = Permission::orderBy('id')->pluck('id')->toArray();

        $allPermissions = Permission::select('id', 'name', 'description')->get();

        return view('livewire.role-permission-assignment-live', [
            'allPermissionIds' => $allPermissionIds,
            'allPermissions' => $allPermissions,
        ]);
    }
}
