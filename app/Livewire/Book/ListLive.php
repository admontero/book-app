<?php

namespace App\Livewire\Book;

use App\Models\Book;
use App\Traits\HasSort;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public array $sortableColumns = ['created_at', 'title'];

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
        $books = Book::select(['id', 'title', 'publication_year'])
            ->with(['genres:id,name,slug', 'pseudonyms:id,name,author_id', 'pseudonyms.author:id,full_name'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.book.list-live', [
            'books' => $books,
        ]);
    }
}
