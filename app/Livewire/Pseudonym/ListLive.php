<?php

namespace App\Livewire\Pseudonym;

use App\Models\Pseudonym;
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

    public ?Pseudonym $pseudonym = null;

    public array $sortableColumns = ['name', 'authors.full_name'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function pseudonymsCount(): int
    {
        return Pseudonym::count();
    }

    public function render()
    {
        $pseudonyms = Pseudonym::select(['pseudonyms.id', 'pseudonyms.name', 'pseudonyms.slug', 'pseudonyms.author_id'])
            ->leftJoin('authors', 'pseudonyms.author_id', '=', 'authors.id')
            ->leftJoin('countries', 'authors.country_birth_id', '=', 'countries.id')
            ->with(['author:id,full_name,country_birth_id', 'author.country_birth:id,name,iso2'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.pseudonym.list-live', [
            'pseudonyms' => $pseudonyms,
        ]);
    }
}
