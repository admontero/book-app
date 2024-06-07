<?php

namespace App\Livewire\Editorial;

use App\Livewire\Forms\EditorialForm;
use App\Models\Editorial;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditLive extends Component
{
    #[Locked]
    public $id;

    public ?Editorial $editorial = null;

    public bool $isOpen = false;

    public EditorialForm $form;

    #[On('show-modal-{id}')]
    public function setEditorial(): void
    {
        $this->editorial = Editorial::firstWhere('id', $this->id);

        if (! $this->editorial) {

            $this->dispatch('new-alert', message: 'No se encontró la editorial a editar, inténtelo de nuevo...', type: 'danger');

            return ;
        }

        $this->form->setEditorial($this->editorial);

        $this->isOpen = true;
    }

    public function update(): void
    {
        $this->form->save();

        $this->reset(['editorial', 'isOpen']);

        $this->dispatch('saved')->self();
        $this->dispatch('new-alert', message: 'Editorial actualizada con éxito', type: 'success');
    }

    public function render()
    {
        return view('livewire.editorial.edit-live');
    }
}
