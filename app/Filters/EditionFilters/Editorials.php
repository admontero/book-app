<?php

namespace App\Filters\EditionFilters;

use App\Filters\FilterContract;
use App\Filters\QueryFilter;

class Editorials extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        if (! $value) return ;

        $this->query->whereIn('editorial_id', $value);
    }
}
