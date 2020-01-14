<?php

namespace App\MagicalKenya\Filters;

use Closure;

abstract class ModelFilter
{
    public function handle($queryBuilder, Closure $next)
    {
        $queryBuilder = $this->applyFilter($queryBuilder);

        return $next($queryBuilder);
    }

    abstract public function applyFilter($query);
}
