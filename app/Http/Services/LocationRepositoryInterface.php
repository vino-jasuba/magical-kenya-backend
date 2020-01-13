<?php

namespace App\Http\Services;

use App\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface LocationRepositoryInterface
{
    /**
     * Create a new Tourist Destination
     *
     * @param Request $request
     * @return Location
     */
    public function createTouristDestination(Request $request) : Location;

    /**
     * Update Tourist destination details
     *
     * @param Request $request
     * @param Location $location
     * @return Location
     */
    public function updateTouristDestination(Request $request, Location $location) : Location;

    /**
     * Fetch List of all available destinations
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getAllTouristDestinations(Request $request) : LengthAwarePaginator;

    /**
     * Soft Delete Destination
     *
     * @param Location $location
     * @return void
     */
    public function removeLocationFromListing(Location $location);
}
