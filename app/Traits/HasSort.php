<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait HasSort
{
    #[Url(except: 'id')]
    public $sortField = 'id';
    #[Url]
    public $sortDirection = 'asc';

    public function validateSorting(array $fields = [])
    {
        if (! in_array($this->sortField, array_merge(['id'], $fields))) {
            $this->sortField = 'name';
        }

        if (! in_array($this->sortDirection, ['asc', 'desc'])) {
            $this->sortDirection = 'asc';
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->sortField = $field;
        $this->reset('sortDirection');
    }
}

