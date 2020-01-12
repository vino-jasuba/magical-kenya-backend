<?php

namespace App\Http\Repositories;

use App\Activity;
use App\Http\Services\ActivityRepositoryService;
use App\MagicalKenya\Traits\PaginatorLength;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityRepository implements ActivityRepositoryService
{
    use PaginatorLength;

    public function createActivity(\Illuminate\Http\Request $request): \App\Activity
    {
        return Activity::create($request->all());
    }

    public function updateActivity(\Illuminate\Http\Request $request, \App\Activity $activity): \App\Activity
    {
        $activity->fill($request->input());
        $activity->save();
        return $activity;
    }

    public function deleteActivity(\App\Activity $activity)
    {
        $activity->delete();
    }

    public function listActivities(\Illuminate\Http\Request $request): LengthAwarePaginator
    {
        return Activity::paginate($this->perPage($request));
    }
}
