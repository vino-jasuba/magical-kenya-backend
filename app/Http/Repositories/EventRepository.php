<?php

namespace App\Http\Repositories;

use App\Event;
use App\Http\Contracts\EventRepositoryContract;
use App\MagicalKenya\Traits\PaginatorLength;

class EventRepository implements EventRepositoryContract
{
    use PaginatorLength;

    /** @inheritDoc */
    public function getUpcomingEvents(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Event::upcoming()->paginate($this->perPage(request()));
    }

    /** @inheritDoc */
    public function getPastEvents(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Event::past()->paginate($this->perPage(request()));
    }

    /** @inheritDoc */
    public function createEvent(\Illuminate\Http\Request $request): \App\Event
    {
        $event = Event::create($request->input());
        return $event;
    }

    /** @inheritDoc */
    public function updateEvent(\Illuminate\Http\Request $request, \App\Event $event): \App\Event
    {
        $event->fill($request->input());
        $event->save();
        return $event;
    }

    /** @inheritDoc */
    public function deleteEvent(\App\Event $event)
    {
        $event->delete();
    }
}
