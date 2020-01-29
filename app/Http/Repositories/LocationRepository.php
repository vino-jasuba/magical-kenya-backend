<?php

namespace App\Http\Repositories;

use App\Http\Contracts\LocationRepositoryContract;
use App\Location;
use App\MagicalKenya\Traits\PaginatorLength;
use App\Media;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LocationRepository implements LocationRepositoryContract
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
        return Location::orderBy('created_at', 'desc')->paginate($this->perPage($request));
    }

    public function removeLocationFromListing(\App\Location $location)
    {
        $location->delete();
    }
}
