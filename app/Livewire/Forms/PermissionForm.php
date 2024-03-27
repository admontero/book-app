<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Form
{
    public ?Permission $permission = null;

    #[Validate('nullable|max:180')]
    public $description;

    public function validationAttributes(): array
    {
        return [
            'description' => 'descripción',
        ];
    }

    public function setPermission(Permission $permission)
    {
        $this->permission = $permission;

        $this->fill($permission);

        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $this->permission->update($this->only(['description']));
    }
}
