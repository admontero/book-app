<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait HasSort
{
    #[Url]
    public $sortColumn = null;

    #[Url]
    public $sortDirection = 'asc';

    public function mountHasSort(): void
    {
        if ($this->isInvalidSortColumn()) $this->reset('sortColumn');

        if ($this->isInvalidSortDirection()) $this->reset('sortDirection');
    }

    public function isInvalidSortColumn(string $column = null): bool
    {
        if (! in_array($column ?? $this->sortColumn, $this->sortableColumns ?? [])) {
            return true;
        }

        return false;
    }

    public function isInvalidSortDirection(): bool
    {
        if (! in_array($this->sortDirection, ['asc', 'desc'])) {
            return true;
        }

        return false;
    }

    public function sortBy(string $column): void
    {
        if ($this->isInvalidSortColumn($column)) {
            $this->reset('sortColumn');

            return ;
        }

        if ($this->isInvalidSortDirection()) {
            $this->reset('sortDirection');

            return ;
        }

        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return ;
        }

        $this->sortColumn = $column;
        $this->reset('sortDirection');
    }
}

