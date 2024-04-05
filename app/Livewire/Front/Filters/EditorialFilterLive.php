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
        return $this->allEditorials()->firstWhere('id', $id);
    }

    public function allEditorials(): Collection
    {
        return Editorial::select(['id', 'name', 'slug'])->get();
    }

    #[Computed]
    public function editorials(): Collection
    {
        return Cache::remember('editorials-filter:' . $this->search, 3600, function() {
            return Editorial::select('id', 'name', 'slug')
                ->withCount(['editions' => function ($query) {
                    $query->whereHas('copies', fn ($query) => $query->whereIn('status', [CopyStatusEnum::DISPONIBLE->value, CopyStatusEnum::OCUPADA->value]));
                }])
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->get();
        });
    }
}
