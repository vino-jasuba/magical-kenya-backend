<?php

namespace App\MagicalKenya\Filters;

class TagFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        if (request()->tag) {
            return $query->whereHas('tags', function ($q) {
                $q->where('name', request()->tag);
            });
        }

        return $query;
    }
}
