<?php

namespace App\Http\Repositories;

use App\Activity;
use App\Http\Services\ActivityRepositoryService;

class ActivityRepository implements ActivityRepositoryService
{
    public function createActivity(\Illuminate\Http\Request $request): \App\Activity
    {
        return Activity::create($request->all());
    }

    public function updateActivity(\Illuminate\Http\Request $request, \App\Activity $activity): \App\Activity
    {

    }

    public function deleteActivity(\Illuminate\Http\Request $request, \App\Activity $activity)
    {

    }

    public function listActivities(\Illuminate\Http\Request $request): \Illuminate\Support\Collection
    {

    }
}
