<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserRoleAssignmentLive extends Component
{
    public User $user;

    #[Validate('required|exists:roles,id')]
    public int $roleId = 0;

    public function mount(): void
    {
        $this->user->load('roles:id,name');

        if ($this->user->roles->first()) {
            $this->roleId = $this->user->roles->first()->id;
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->user->syncRoles($this->roleId);
    }

    public function render()
    {
        $roles = Role::with('permissions:id,name,description')->get(['id', 'name']);

        return view('livewire.user-role-assignment-live', [
            'roles' => $roles,
        ]);
    }
}
