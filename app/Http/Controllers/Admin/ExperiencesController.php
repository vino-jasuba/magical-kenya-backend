<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TouristExperience;
use Illuminate\Http\Request;

class ExperiencesController extends Controller
{
    public function index()
    {
        return view('experiences.index')->with(['experiences' => TouristExperience::paginate()]);
    }

    public function create()
    {
        return view('experiences.create');
    }

    public function edit(TouristExperience $experience)
    {
        return view('experiences.edit')->with(compact('experience'));
    }
}
