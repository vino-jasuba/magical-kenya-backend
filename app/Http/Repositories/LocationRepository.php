<?php

namespace App\Http\Repositories;

use App\Http\Services\LocationRepositoryInterface;
use App\Location;
use App\MagicalKenya\Traits\PaginatorLength;

class LocationRepository implements LocationRepositoryInterface
{
    use PaginatorLength;

    public function createTouristDestination(\Illuminate\Http\Request $request): \App\Location
    {
        $location = Location::create($request->input());

        return $location;
    }

    public function updateTouristDestination(\Illuminate\Http\Request $request, \App\Location $location): \App\Location
    {
        $location->fill($request->input());
        $location->save();
        return $location;
    }

    public function getAllTouristDestinations(\Illuminate\Http\Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Location::paginate($this->perPage($request));
    }
}
