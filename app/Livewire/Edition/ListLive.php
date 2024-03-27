<?php

namespace App\Livewire\Edition;

use App\Models\Edition;
use App\Traits\HasSort;
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

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'books.title', 'editorial.name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function editionsCount(): int
    {
        return Edition::count();
    }

    public function render()
    {
        $editions = Edition::select('editions.id', 'editions.isbn13', 'editions.year', 'editions.book_id', 'editions.editorial_id')
            ->leftJoin('books', 'editions.book_id', '=', 'books.id')
            ->leftJoin('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->with('book:id,title', 'editorial:id,name,slug')
            ->where(function ($query) {
                $query->where('editions.isbn13', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('book', 'books.title', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.edition.list-live', [
            'editions' => $editions,
        ]);
    }
}
