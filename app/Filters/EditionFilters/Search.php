<?php

namespace App\Filters\EditionFilters;

use App\Filters\FilterContract;
use App\Filters\QueryFilter;

class Search extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        if (! $value) return ;

        $this->query->whereRelation('book', 'title', 'like', '%' . $value . '%');
    }
}
