<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index')->with(['events' => Event::paginate()]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function edit(Event $event)
    {
        return view('events.edit')->with(compact('event'));
    }
}
