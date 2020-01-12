<?php

namespace App\Http\Services;

use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ActivityRepositoryService
{
    /**
     * Create a new activity
     *
     * @param Request $request
     * @return Activity
     */
    public function createActivity(Request $request) : Activity;

    /**
     * Soft delete an existing activity
     *
     * @param Request $request
     * @param Activity $activity
     * @return void
     */
    public function deleteActivity(Request $request, Activity $activity);

    /**
     * Update the details on an existing activity
     *
     * @param Request $request
     * @param Activity $activity
     * @return Activity
     */
    public function updateActivity(Request $request, Activity $activity) : Activity;


    /**
     * Fetch a list of activities using given filters
     *
     * @return Collection
     */
    public function listActivities(Request $request) : Collection;
}
