<?php

namespace App\MagicalKenya\Filters;

class LocationFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        if (request()->location) {
            return $query->whereHas('location', function ($q) {
                $q->where('name', request()->location);
            });
        }

        return $query;
    }
}
