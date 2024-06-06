<?php

namespace App\Livewire\Author;

use App\Models\Author;
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

    public ?Author $author = null;

    public array $sortableColumns = ['full_name', 'countries.name'];

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
        $authors = Author::select(['authors.id', 'authors.full_name', 'authors.photo_path', 'authors.country_birth_id'])
            ->leftJoin('countries', 'authors.country_birth_id', '=', 'countries.id')
            ->with(['country_birth:id,name,iso2'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.author.list-live', [
            'authors' => $authors,
        ]);
    }
}
