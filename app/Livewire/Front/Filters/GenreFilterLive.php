<?php

namespace App\Livewire\Front\Filters;

use App\Models\Genre;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class GenreFilterLive extends Component
{
    #[Modelable]
    public $value = [];

    public $search = '';

    public function genre(int $id): ?Genre
    {
        return $this->allGenres->firstWhere('id', $id);
    }

    #[Computed(cache: true, key: 'genres-filter', tags: 'genres')]
    public function allGenres(): Collection
    {
        return Genre::select(['id', 'name', 'slug'])->get();
    }

    #[Computed]
    public function genres(): Collection
    {
        return Cache::tags(config('cache.tags.front_filters_genres_filter_live.name'))
            ->remember('genres-filter:' . $this->search, 3600, function() {
                return Genre::select(['id', 'name', 'slug'])
                    ->withCount(['editions' => function ($query) {
                        $query->has('enabledCopies');
                    }])
                    ->search($this->search)
                    ->orderBy('name')
                    ->get();
            });
    }
}
