<?php

namespace App\MagicalKenya\Filters;

class LocationFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        $location = request()->location;

        if ($location) {
            return $query->whereHas('location', function ($q) use ($location) {
                $q->where('name', $location)->orWhere('slug', $location);
            });
        }

        return $query;
    }
}
