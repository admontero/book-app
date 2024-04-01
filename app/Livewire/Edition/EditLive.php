<?php

namespace App\Livewire\Edition;

use App\Livewire\Forms\EditionForm;
use App\Models\Edition;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditLive extends Component
{
    use WithFileUploads;

    public Edition $edition;

    public EditionForm $form;

    public function mount(Edition $edition): void
    {
        $this->form->loadBooks();

        $this->form->loadEditorials();

        $this->form->setEdition($edition);
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('new-alert', message: 'Edición actualizada con éxito', type: 'success');

        $this->redirect(route('back.editions.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.edition.edit-live');
    }
}
