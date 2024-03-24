<?php

namespace App\Livewire;

use App\Models\Book;
use App\Traits\HasSort;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BookListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'title', 'authors.name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function booksCount(): int
    {
        return Book::count();
    }

    public function render(): View
    {
        $books = Book::select('books.id', 'books.title', 'books.publication_year', 'books.author_id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->with('author:id,name', 'genres:id,name,slug')
            ->where(function ($query) {
                $query->where('books.title', 'like', '%' . $this->search . '%')
                    ->orWhere('books.publication_year', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('author', 'name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.book-list-live', [
            'books' => $books,
        ]);
    }
}
