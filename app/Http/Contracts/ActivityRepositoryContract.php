<?php

namespace App\Http\Contracts;

use App\Activity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ActivityRepositoryContract
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
     * @param Activity $activity
     * @return void
     */
    public function deleteActivity(Activity $activity);

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
    public function listActivities(Request $request) : LengthAwarePaginator;
}
