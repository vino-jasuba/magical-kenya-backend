<?php

namespace App\Http\Repositories;

use App\Activity;
use App\Http\Contracts\SearchServiceInterface;
use App\Location;
use App\TouristExperience;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Searchable\Search;
use Spatie\Searchable\SearchResultCollection;

class EloquentSearchRepository implements SearchServiceInterface
{
    /** @inheritDoc */
    public function search(\Illuminate\Http\Request $request) : SearchResultCollection
    {
        $query = $request->input('q');

        /** this is to prevent searches that result in too many matches */
        throw_if(strlen($query) < 4, ModelNotFoundException::class, 'query string too short');

        $results = (new Search)
            ->registerModel(Location::class, ['name'])
            ->registerModel(Activity::class, ['name'])
            ->registerModel(TouristExperience::class, ['description'])
            ->perform($query);

        return $results;
    }
}
