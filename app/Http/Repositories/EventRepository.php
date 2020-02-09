<?php

namespace App\Http\Repositories;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\MagicalKenya\Traits\PaginatorLength;
use App\Http\Contracts\EventRepositoryContract;
use App\MagicalKenya\Filters\DateFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryContract
{
    use PaginatorLength;

    /** @inheritDoc */
    public function getAllEvents(Request $request): LengthAwarePaginator
    {
        $queryBuilder = Event::query();

        return app(Pipeline::class)
            ->send($queryBuilder)
            ->through([
                DateFilter::class,
            ])
            ->thenReturn()
            ->paginate($this->perPage($request));
    }

    /** @inheritDoc */
    public function createEvent(Request $request):Event
    {
        $event = Event::create($request->input());
        return $event;
    }

    /** @inheritDoc */
    public function updateEvent(Request $request, Event $event):Event
    {
        $event->fill($request->input());
        $event->save();
        return $event;
    }

    /** @inheritDoc */
    public function deleteEvent(Event $event)
    {
        $event->delete();
    }
}
