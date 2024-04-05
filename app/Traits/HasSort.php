<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait HasSort
{
    #[Url(except: 'id')]
    public $sortField = 'id';

    #[Url]
    public $sortDirection = 'desc';

    public function validateSorting(array $fields = [])
    {
        if (! in_array($this->sortField, $fields)) {
            $this->reset('sortField');
        }

        if (! in_array($this->sortDirection, ['asc', 'desc'])) {
            $this->reset('sortDirection');
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

