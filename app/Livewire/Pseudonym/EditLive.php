<?php

namespace App\Livewire\Pseudonym;

use App\Livewire\Forms\PseudonymForm;
use App\Models\Pseudonym;
use Livewire\Component;

class EditLive extends Component
{
    public ?Pseudonym $pseudonym = null;

    public PseudonymForm $form;

    public function mount(Pseudonym $pseudonym): void
    {
        $this->form->setPseudonym($pseudonym);

        $this->form->loadAuthors();
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('new-alert', message: 'Pseudónimo actualizado con éxito', type: 'success');

        $this->redirect(route('back.pseudonyms.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pseudonym.edit-live');
    }
}
