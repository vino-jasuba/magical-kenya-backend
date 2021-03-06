<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LocationResource;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Requests\CreateLocationRequest;
use App\Http\Contracts\LocationRepositoryContract;

class LocationController extends Controller
{
    protected $locationRepository;

    public function __construct(LocationRepositoryContract $locationRepository)
    {
        $this->middleware('auth:api')->except(['show', 'index']);
        $this->locationRepository = $locationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locationCollection = $this->locationRepository->touristDestinationsPaginate($request);

        return LocationResource::collection($locationCollection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocationRequest $request)
    {
        $destination = $this->locationRepository->createTouristDestination($request);

        return new LocationResource($destination);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return new LocationResource($location);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        $updatedLocation = $this->locationRepository->updateTouristDestination($request, $location);

        return new LocationResource($updatedLocation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $this->locationRepository->removeLocationFromListing($location);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
