<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TouristExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->location->name . ' ' . $this->activity->name,
            'description' => $this->description,
        ];
    }
}
