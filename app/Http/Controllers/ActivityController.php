<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Services\ActivityRepositoryService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityRepository;

    public function __construct(ActivityRepositoryService $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateActivityRequest $request)
    {
        $activity = $this->activityRepository->createActivity($request);

        return new ActivityResource($activity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
