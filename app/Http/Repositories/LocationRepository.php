<?php

namespace App\Http\Repositories;

use App\Location;
use Illuminate\Http\Request;
use App\MagicalKenya\Traits\PaginatorLength;
use App\Http\Contracts\LocationRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LocationRepository implements LocationRepositoryContract
{
    use PaginatorLength;

    public function createTouristDestination(Request $request): Location
    {
        $location = Location::create($request->input());
        return $location;
    }

    public function updateTouristDestination(Request $request, Location $location): Location
    {
        $location->fill($request->input());
        $location->save();
        return $location;
    }

    public function touristDestinationsPaginate(Request $request): LengthAwarePaginator
    {
        return Location::withCount('experiences')->latest()->paginate($this->perPage($request));
    }

    public function removeLocationFromListing(Location $location)
    {
        $location->experiences()->delete();
        $location->delete();
    }
}
