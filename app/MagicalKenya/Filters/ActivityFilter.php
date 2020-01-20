<?php

namespace App\MagicalKenya\Filters;

class ActivityFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        if (request()->activity) {
            return $query->whereHas('activity', function ($q) {
                $q->where('name', request()->activity);
            });
        }

        return $query;
    }
}
