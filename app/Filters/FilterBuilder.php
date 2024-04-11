<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;

    public function __construct($query, $filters, $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }

    public function apply(): Builder
    {
        foreach ($this->filters as $name => $value) {
            $normailizedName = ucfirst($name);

            $class = $this->namespace . "\\{$normailizedName}";

            if (! class_exists($class)) continue;

            (new $class($this->query))->handle($value);
        }

        return $this->query;
    }
}
