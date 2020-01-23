<?php

namespace App\MagicalKenya\Filters;

class ActivityFilter extends ModelFilter
{
    public function applyFilter($query)
    {
        $activity = request()->activity;

        if ($activity) {
            return $query->whereHas('activity', function ($q) use ($activity) {
                $q->where('name', $activity)->orWhere('slug', $activity);
            });
        }

        return $query;
    }
}
