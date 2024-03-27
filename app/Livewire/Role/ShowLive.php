<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class ShowLive extends Component
{
    public Role $role;

    public function render()
    {
        return view('livewire.role.show-live');
    }
}
