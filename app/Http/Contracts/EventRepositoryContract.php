<?php

namespace App\Http\Contracts;

use App\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface EventRepositoryContract
{

    public function getAllEvents(Request $request) : LengthAwarePaginator;
    /**
     * Save new event to database
     *
     * @param Request $request
     * @return Event
     */
    public function createEvent(Request $request) : Event;

    /**
     * Update details of an event
     *
     * @param Request $request
     * @param Event $event
     * @return Event
     */
    public function updateEvent(Request $request, Event $event) : Event;

    /**
     * Soft delete event
     *
     * @param Event $event
     * @return void
     */
    public function deleteEvent(Event $event);
}
