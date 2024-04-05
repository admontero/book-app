<?php

namespace App\Livewire\Front\Filters;

use App\Enums\CopyStatusEnum;
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
        return $this->allGenres()->firstWhere('id', $id);
    }

    public function allGenres(): Collection
    {
        return Genre::select(['id', 'name', 'slug'])->get();
    }

    #[Computed]
    public function genres(): Collection
    {
        return Cache::remember('genres-filter:' . $this->search, 3600, function() {
            return Genre::select(['id', 'name', 'slug'])
                ->withCount(['editions' => function ($query) {
                    $query->whereHas('copies', fn ($query) => $query->whereIn('status', [CopyStatusEnum::DISPONIBLE->value, CopyStatusEnum::OCUPADA->value]));
                }])
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->get();
        });
    }
}
