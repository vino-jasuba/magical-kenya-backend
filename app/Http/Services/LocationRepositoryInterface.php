<?php

namespace App\Http\Services;

use App\Location;
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
}
