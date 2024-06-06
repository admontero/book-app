<?php

namespace App\Livewire\Front\Filters;

use App\Models\Pseudonym;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class PseudonymFilterLive extends Component
{
    #[Modelable]
    public $value = [];

    public $search = '';

    public function pseudonym(int $id): ?Pseudonym
    {
        return $this->allPseudonyms->firstWhere('id', $id);
    }

    #[Computed(cache: true, key: 'pseudonyms-filter', tags: 'pseudonyms')]
    public function allPseudonyms(): Collection
    {
        return Pseudonym::select(['id', 'name'])->get();
    }

    #[Computed]
    public function pseudonyms(): Collection
    {
        return Cache::tags(config('cache.tags.front_filters_pseudonyms_filter_live.name'))
            ->remember('pseudonyms-filter:' . $this->search, 3600, function() {
                return Pseudonym::select(['id','name',])
                    ->withCount(['editions' => function ($query) {
                        $query->has('enabledCopies');
                    }])
                    ->search($this->search)
                    ->orderBy('name')
                    ->get();
            });
    }
}
