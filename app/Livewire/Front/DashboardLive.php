<?php

namespace App\Livewire\Front;

use App\Models\Edition;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.front')]
class DashboardLive extends Component
{
    use WithPagination;

    public int $perPage = 25;

    public array $filters = [
        'search' => '',
        'genres' => [],
        'editorials' => [],
        'pseudonyms' => [],
    ];

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedFilters(): void
    {
        $this->resetPage();
    }

    public function resetFilter(string $property, int|string|array|bool $value): void
    {
        if (! $property) return ;

        if (! isset($this->filters[$property])) return ;

        $this->filters[$property] = $value;

        $this->resetPage();
    }

    public function remove(string $property, int $id): void
    {
        $this->filters[$property] = array_values(array_filter($this->filters[$property], fn ($item) => $item != $id));
    }

    public function cacheKey(): string
    {
        $cache_key = "homepage:perPage={$this->perPage}";

        $filters = array_filter($this->filters);

        foreach ($filters as $key => $value) {
            if (is_array($value)) $value = implode(',', $value);

            $cache_key .= ";{$key}={$value}";
        }

        $cache_key .= ";page={$this->getPage()}";

        return $cache_key;
    }

    #[Computed]
    public function isFilterEmpty(): bool
    {
        return empty(array_filter($this->filters));
    }

    public function render(): View
    {
        $editions = Cache::tags(config('cache.tags.front_dashboard_live.name'))
            ->remember($this->cacheKey(), 3600, function () {
                return Edition::select(['id', 'book_id', 'slug', 'cover_path'])
                    ->with('copies:id,edition_id,status', 'book:id,title,slug', 'book.genres:id,name,slug')
                    ->has('enabledCopies')
                    ->filterBy($this->filters)
                    ->latest('id')
                    ->paginate($this->perPage);
                });

        Session::put('page', $this->getPage());

        return view('livewire.front.dashboard-live', [
            'editions' => $editions,
            'perPageOptions' => [25, 50, 75, 100],
        ]);
    }
}
