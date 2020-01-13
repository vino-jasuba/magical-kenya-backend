<?php

namespace App\Http\Repositories;

use App\Http\Services\LocationRepositoryInterface;
use App\Location;

class LocationRepository implements LocationRepositoryInterface
{
    public function createTouristDestination(\Illuminate\Http\Request $request): \App\Location
    {
        $location = Location::create($request->input());

        return $location;
    }
}
