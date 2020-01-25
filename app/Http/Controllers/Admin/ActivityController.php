<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index()
    {
        return view('activities.index')->with(['activities' => Activity::withCount('experiences')->paginate()]);
    }

    public function create()
    {
        return view('activities.create');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit')->with(compact('activity'));
    }
}
