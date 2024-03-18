<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleShowLive extends Component
{
    public Role $role;

    public function render()
    {
        return view('livewire.role-show-live');
    }
}
