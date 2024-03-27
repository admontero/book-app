<?php

namespace App\Livewire\Copy;

use App\Livewire\Forms\CopyForm;
use App\Models\Copy;
use Illuminate\View\View;
use Livewire\Component;

class EditLive extends Component
{
    public Copy $copy;

    public CopyForm $form;

    public function mount(Copy $copy): void
    {
        $this->form->loadEditions();

        $this->form->setCopy($copy);

        $this->form->setIsRetired($copy->status);
    }

    public function updatedFormStatus(string $value): void
    {
        $this->form->setIsRetired($value);
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('new-alert', message: 'Copia actualizada con éxito', type: 'success');

        $this->redirect(route('admin.copies.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.copy.edit-live');
    }
}
