<?php

namespace App\MagicalKenya\Filters;

class DateFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        $request = request();

        if ($request->q == 'upcoming') {
            return $query->upcoming();
        }

        if ($request->q == 'past') {
            return $query->past();
        }

        return $query;
    }
}
