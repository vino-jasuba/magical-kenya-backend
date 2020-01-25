<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        return view('locations.index')->with(['locations' => Location::withCount('experiences')->paginate()]);
    }

    public function create()
    {
        return view('locations.create');
    }

    public function edit(Location $location)
    {
        return view('locations.edit')->with(compact('location'));
    }
}
