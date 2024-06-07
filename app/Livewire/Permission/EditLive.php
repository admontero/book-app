<?php

namespace App\Livewire\Permission;

use App\Livewire\Forms\PermissionForm;
use App\Models\Permission;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditLive extends Component
{
    #[Locked]
    public $id;

    public ?Permission $permission = null;

    public bool $isOpen = false;

    public PermissionForm $form;

    #[On('show-modal-{id}')]
    public function setPermission(): void
    {
        $this->permission = Permission::firstWhere('id', $this->id);

        if (! $this->permission) {

            $this->dispatch('new-alert', message: 'No se encontró el permiso a editar, inténtelo de nuevo...', type: 'danger');

            return ;
        }

        $this->form->setPermission($this->permission);

        $this->isOpen = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->reset(['permission', 'isOpen']);

        $this->dispatch('saved')->self();
        $this->dispatch('new-alert', message: 'Permiso actualizado con éxito', type: 'success');
    }

    public function render()
    {
        return view('livewire.permission.edit-live');
    }
}
