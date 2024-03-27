<?php

namespace App\Livewire\Book;

use App\Livewire\Forms\BookForm;
use App\Livewire\Forms\GenreForm;
use App\Models\Book;
use Illuminate\View\View;
use Livewire\Component;

class EditLive extends Component
{
    public ?Book $book = null;

    public BookForm $form;

    public GenreForm $genreForm;

    public function mount(Book $book): void
    {
        $this->form->setBook($book);

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

        $this->dispatch('new-alert', message: 'Libro actualizado con éxito', type: 'success');

        $this->redirect(route('admin.books.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.book.edit-live');
    }
}
