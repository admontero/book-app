<?php

namespace App\Livewire\Copy;

use App\Models\Copy;
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

    #[Url(except: '')]
    public $statuses = '';

    public array $sortableColumns = ['books.title'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setStatuses(string $name): void
    {
        $statusesFilterArray = array_filter(explode(',', $this->statuses));

        if (in_array($name, $statusesFilterArray)) {
            $statusesFilterArray = array_diff($statusesFilterArray, [$name]);
        } else {
            $statusesFilterArray[] = $name;
        }

        $this->statuses = implode(',', $statusesFilterArray);
        $this->resetPage();
    }

    #[Computed]
    public function statusesArray(): array
    {
        return array_filter(explode(',', $this->statuses));
    }

    #[Computed]
    public function copiesCount(): int
    {
        return Copy::count();
    }

    public function render()
    {
        $copies = Copy::select(['copies.id','copies.edition_id','copies.identifier','copies.is_loanable','copies.status'])
            ->leftJoin('editions', 'copies.edition_id', '=', 'editions.id')
            ->leftJoin('books', 'editions.book_id', '=', 'books.id')
            ->leftJoin('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->leftJoin('book_pseudonym', 'editions.book_id', '=', 'book_pseudonym.book_id')
            ->with([ 'edition:id,book_id,editorial_id', 'edition.book:id,title', 'edition.editorial:id,name', 'edition.book.pseudonyms:id,name'])
            ->search($this->search)
            ->inStatuses($this->statusesArray)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.copy.list-live', [
            'copies' => $copies,
        ]);
    }
}
