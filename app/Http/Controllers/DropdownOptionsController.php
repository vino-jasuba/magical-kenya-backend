<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Location;
use Illuminate\Http\Request;

class DropdownOptionsController extends Controller
{
    public function __invoke()
    {
        return [
            'activities' => Activity::latest()->get(['id', 'name']),
            'locations' => Location::latest()->get(['id', 'name']),
        ];
    }
}
