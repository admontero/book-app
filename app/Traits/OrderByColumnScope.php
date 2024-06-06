<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OrderByColumnScope
{
    public function scopeOrderByColumn(Builder $query, ?string $column = null, ?string $direction = 'asc'): void
    {
        $query->when(
            $column,
            fn ($query) => $query->orderBy($column, $direction),
            fn ($query) => $query->latest($this->getTable() . '.created_at')
        );
    }
}
