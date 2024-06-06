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

    public array $sortableColumns = ['books.title', 'editorials.name'];

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
        $editions = Edition::select(['editions.id', 'editions.isbn13', 'editions.year', 'editions.book_id', 'editions.editorial_id'])
            ->leftJoin('books', 'editions.book_id', '=', 'books.id')
            ->leftJoin('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->with(['book:id,title', 'editorial:id,name,slug'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.edition.list-live', [
            'editions' => $editions,
        ]);
    }
}
