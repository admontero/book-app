<?php

namespace App\Livewire;

use App\Models\Author;
use App\Traits\HasSort;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AuthorListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public ?Author $author = null;

    public function mount(): void
    {
        $this->validateSorting(fields: ['name', 'countries.name']);
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
        $authors = Author::select('authors.id', 'authors.name', 'authors.photo_path', 'authors.country_birth_id')
            ->leftJoin('countries', 'authors.country_birth_id', '=', 'countries.id')
            ->with('country_birth:id,name,iso2')
            ->where(function ($query) {
                $query->where('authors.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.author-list-live', [
            'authors' => $authors,
        ]);
    }
}
