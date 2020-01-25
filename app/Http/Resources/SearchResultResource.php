<?php

namespace App\Http\Resources;

use App\Activity;
use App\Location;
use App\TouristExperience;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $searchables = [
            Activity::class => ActivityResource::class,
            Location::class => LocationResource::class,
            TouristExperience::class => TouristExperienceResource::class,
        ];

        $searchableClassName = get_class($this->searchable);

        return [
            'searchable' => new $searchables[$searchableClassName]($this->searchable),
            'searchable_type' => strtolower(class_basename($searchableClassName)),
            'title' => $this->title,
            'url' => $this->url,
        ];
    }
}
