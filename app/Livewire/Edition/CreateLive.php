<?php

namespace App\Livewire\Edition;

use App\Livewire\Forms\EditionForm;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateLive extends Component
{
    use WithFileUploads;

    public EditionForm $form;

    public function mount(): void
    {
        $this->form->loadBooks();

        $this->form->loadEditorials();
    }

    public function save(): void
    {
        $this->form->save();

        $this->form->reset('edition');

        $this->dispatch('new-alert', message: 'Edición creada con éxito', type: 'success');

        $this->redirect(route('back.editions.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.edition.create-live');
    }
}
