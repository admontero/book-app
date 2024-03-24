<?php

namespace App\Livewire;

use App\Livewire\Forms\AuthorForm;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class AuthorCreateLive extends Component
{
    use WithFileUploads;

    public AuthorForm $form;

    public function mount(): void
    {
        $this->form->loadCountries();
    }

    public function setCountryBirth(int $value): void
    {
        $this->form->setCountryBirth($value);

        $this->dispatch('states_loaded');
    }

    public function setStateBirth(int $value): void
    {
        $this->form->setStateBirth($value);

        $this->dispatch('cities_loaded');
    }

    public function setCityBirth(int $value): void
    {
        $this->form->setCityBirth($value);
    }

    public function save(): void
    {
        $this->validate();

        $this->form->save();

        $this->dispatch('new-alert', message: 'Autor agregado con éxito', type: 'success');

        $this->redirect(route('admin.authors.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.author-create-live');
    }
}
