<?php

namespace App\Livewire\Copy;

use App\Livewire\Forms\CopyForm;
use Illuminate\View\View;
use Livewire\Component;

class CreateLive extends Component
{
    public CopyForm $form;

    public function mount(): void
    {
        $this->form->loadEditions();
    }

    public function updatedFormStatus(string $value): void
    {
        $this->form->setIsRetired($value);
    }

    public function save(): void
    {
        $this->form->save();

        $this->form->reset('copy');

        $this->dispatch('new-alert', message: 'Copia creada con éxito', type: 'success');

        $this->redirect(route('back.copies.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.copy.create-live');
    }
}
