<?php

namespace App\Livewire\Pseudonym;

use App\Livewire\Forms\PseudonymForm;
use Livewire\Component;

class CreateLive extends Component
{
    public PseudonymForm $form;

    public function mount(): void
    {
        $this->form->loadAuthors();
    }

    public function save(): void
    {
        $this->validate();

        $this->form->save();

        $this->form->reset('pseudonym');

        $this->dispatch('new-alert', message: 'Pseudónimo agregado con éxito', type: 'success');

        $this->redirect(route('back.pseudonyms.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pseudonym.create-live');
    }
}
