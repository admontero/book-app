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

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'books.title']);
    }

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
        $copies = Copy::select([
                'copies.id',
                'copies.edition_id',
                'copies.identifier',
                'copies.is_loanable',
                'copies.status'
            ])
            ->leftJoin('editions', 'copies.edition_id', '=', 'editions.id')
            ->leftJoin('books', 'editions.book_id', '=', 'books.id')
            ->leftJoin('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->with([
                'edition:id,book_id,editorial_id',
                'edition.book:id,title,author_id',
                'edition.editorial:id,name',
                'edition.book.author:id,firstname,lastname,pseudonym'
            ])
            ->when($this->statusesArray, function ($query) {
                $query->whereIn('copies.status', $this->statusesArray);
            })
            ->where(function ($query) {
                $query->where('copies.identifier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('edition', function ($query) {
                        $query->whereRelation('book', 'books.title', 'like', '%' . $this->search . '%')
                            ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $this->search . '%')
                            ->orWhereHas('book', function ($query) {
                                $query->whereRelation('author', 'firstname', 'like', '%' . $this->search . '%')
                                    ->orWhereRelation('author', 'lastname', 'like', '%' . $this->search . '%')
                                    ->orWhereRelation('author', 'pseudonym', 'like', '%' . $this->search . '%');
                            });
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.copy.list-live', [
            'copies' => $copies,
        ]);
    }
}
