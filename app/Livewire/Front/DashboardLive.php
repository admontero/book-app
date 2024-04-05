<?php

namespace App\Livewire\Front;

use App\Enums\CopyStatusEnum;
use App\Models\Edition;
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
        'search' => [],
        'genres' => [],
        'editorials' => [],
        'authors' => [],
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
    }

    public function remove(string $property, int $id): void
    {
        $this->filters[$property] = array_values(array_filter($this->filters[$property], fn ($item) => $item != $id));
    }

    #[Computed]
    public function isFilterEmpty(): bool
    {
        return empty(array_filter($this->filters));
    }

    public function render(): View
    {
        $editions = Edition::with('copies', 'book', 'book.genres:id,name,slug')->whereHas('copies', function ($query) {
            $query->whereIn('status', [CopyStatusEnum::DISPONIBLE->value, CopyStatusEnum::OCUPADA->value]);
        })
            ->when($this->filters['search'], fn ($query) => $query->whereRelation('book', 'title', 'like', '%' . $this->filters['search'] . '%'))
            ->when($this->filters['editorials'], fn ($query) => $query->whereIn('editorial_id', $this->filters['editorials']))
            ->when($this->filters['genres'], fn ($query) => $query->whereHas('book',
                fn ($query) => $query->whereHas('genres',
                    fn ($query) => $query->whereIn('id', $this->filters['genres']))
                )
            )
            ->when($this->filters['authors'], fn ($query) => $query->whereHas('book',
                fn ($query) => $query->whereHas('author',
                    fn ($query) => $query->whereIn('id', $this->filters['authors']))
                )
            )
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.front.dashboard-live', [
            'editions' => $editions,
            'perPageOptions' => [25, 50, 75, 100],
        ]);
    }
}
