<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Contracts\EventRepositoryContract;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public $eventRepository;

    public function __construct(EventRepositoryContract $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upcomingEvents = $this->eventRepository->getUpcomingEvents();
        return EventResource::collection($upcomingEvents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $this->eventRepository->createEvent($request);
        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event = $this->eventRepository->updateEvent($request, $event);
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->eventRepository->deleteEvent($event);
    }
}
