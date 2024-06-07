<?php

namespace App\Livewire\Genre;

use App\Livewire\Forms\GenreForm;
use App\Models\Genre;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditLive extends Component
{
    #[Locked]
    public $id;

    public ?Genre $genre = null;

    public bool $isOpen = false;

    public GenreForm $form;

    #[On('show-modal-{id}')]
    public function setGenre(): void
    {
        $this->genre = Genre::firstWhere('id', $this->id);

        if (! $this->genre) {

            $this->dispatch('new-alert', message: 'No se encontró el género a editar, inténtelo de nuevo...', type: 'danger');

            return ;
        }

        $this->form->setGenre($this->genre);

        $this->isOpen = true;
    }

    public function update(): void
    {
        $this->form->save();

        $this->reset(['genre', 'isOpen']);

        $this->dispatch('saved')->self();
        $this->dispatch('new-alert', message: 'Género actualizado con éxito', type: 'success');
    }

    public function render()
    {
        return view('livewire.genre.edit-live');
    }
}
