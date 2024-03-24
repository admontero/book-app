<?php

namespace App\Livewire;

use App\Livewire\Forms\BookForm;
use App\Livewire\Forms\GenreForm;
use Illuminate\View\View;
use Livewire\Component;

class BookCreateLive extends Component
{
    public BookForm $form;

    public GenreForm $genreForm;

    public function mount(): void
    {
        $this->form->loadAuthors();

        $this->form->loadGenres();
    }

    public function setGenre(int $id): void
    {
        $this->form->setGenre($id);

        $this->dispatch('reset-search');
    }

    public function saveGenre(string $name): void
    {
        $this->form->saveGenre($this->genreForm, $name);
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('new-alert', message: 'Libro creado con éxito', type: 'success');

        $this->redirect(route('admin.books.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.book-create-live');
    }
}
