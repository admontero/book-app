<?php

namespace App\Filters\EditionFilters;

use App\Filters\FilterContract;
use App\Filters\QueryFilter;

class Authors extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        if (! $value) return ;

        $this->query->whereHas('book',
            fn ($query) => $query->whereHas('author',
                fn ($query) => $query->whereIn('id', $value))
            );
    }
}
