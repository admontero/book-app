<?php

namespace App\Livewire\Author;

use App\Models\Author;
use App\Traits\HasSort;
use Illuminate\Support\Facades\DB;
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

    public ?Author $author = null;

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'name', 'countries.name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function authorsCount(): int
    {
        return Author::count();
    }

    public function render(): View
    {
        $authors = Author::select([
                'authors.id',
                'authors.firstname',
                'authors.lastname',
                'authors.pseudonym' ,
                'authors.photo_path',
                'authors.country_birth_id',
                DB::raw('IF(authors.pseudonym, authors.pseudonym, CONCAT_WS(" ", authors.firstname, authors.lastname)) as name'),
            ])
            ->leftJoin('countries', 'authors.country_birth_id', '=', 'countries.id')
            ->with('country_birth:id,name,iso2')
            ->where(function ($query) {
                $query->where('authors.firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('authors.lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('authors.pseudonym', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.author.list-live', [
            'authors' => $authors,
        ]);
    }
}
