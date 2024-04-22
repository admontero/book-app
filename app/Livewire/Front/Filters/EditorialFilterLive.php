<?php

namespace App\Livewire\Front\Filters;

use App\Enums\CopyStatusEnum;
use App\Models\Editorial;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class EditorialFilterLive extends Component
{
    #[Modelable]
    public $value = [];

    public $search = '';

    public function editorial(int $id): ?Editorial
    {
        return $this->allEditorials->firstWhere('id', $id);
    }

    #[Computed(cache: true, key: 'editorials-filter', tags: 'editorials')]
    public function allEditorials(): Collection
    {
        return Editorial::select(['id', 'name', 'slug'])->get();
    }

    #[Computed]
    public function editorials(): Collection
    {
        return Cache::tags(config('cache.tags.front_filters_editorials_filter_live.name'))
            ->remember('editorials-filter:' . $this->search, 3600, function() {
                return Editorial::select('id', 'name', 'slug')
                    ->withCount(['editions' => function ($query) {
                        $query->has('enabledCopies');
                    }])
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orderBy('name')
                    ->get();
            });
    }
}
