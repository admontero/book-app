<?php

namespace App\Livewire\Front\Filters;

use App\Enums\CopyStatusEnum;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AuthorFilterLive extends Component
{
    #[Modelable]
    public $value = [];

    public $search = '';

    public function author(int $id): ?Author
    {
        return $this->allAuthors->firstWhere('id', $id);
    }

    #[Computed(cache: true, key: 'authors-filter')]
    public function allAuthors(): Collection
    {
        return Author::select(['id', 'firstname', 'lastname', 'pseudonym'])->get();
    }

    #[Computed]
    public function authors(): Collection
    {
        return Cache::remember('authors-filter:' . $this->search, 3600, function() {
            return Author::select([
                    'id',
                    'firstname',
                    'lastname',
                    'pseudonym',
                    DB::raw('IF(authors.pseudonym, authors.pseudonym, CONCAT_WS(" ", authors.firstname, authors.lastname)) as name'),
                ])
                ->withCount(['editions' => function ($query) {
                    $query->whereHas('copies', fn ($query) => $query->whereIn('status', [CopyStatusEnum::DISPONIBLE->value, CopyStatusEnum::OCUPADA->value]));
                }])
                ->where(function ($query) {
                    $query->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('pseudonym', 'like', '%' . $this->search . '%');
                })
                ->orderBy('name')
                ->get();
        });
    }
}
