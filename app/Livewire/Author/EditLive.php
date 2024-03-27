<?php

namespace App\Livewire\Author;

use App\Livewire\Forms\AuthorForm;
use App\Models\Author;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditLive extends Component
{
    use WithFileUploads;

    public ?Author $author = null;

    public AuthorForm $form;

    public function mount(Author $author): void
    {
        $this->form->loadCountries();

        $this->form->setAuthor($author);
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
        $this->form->save();

        $this->dispatch('new-alert', message: 'Autor actualizado con éxito', type: 'success');

        $this->redirect(route('admin.authors.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.author.edit-live');
    }
}
