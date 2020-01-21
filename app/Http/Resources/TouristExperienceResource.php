<?php

namespace App\Http\Resources;

use App\MagicalKenya\Traits\HasFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class TouristExperienceResource extends JsonResource
{
    use HasFiles;

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
            'activity' => [
                'name' => $this->activity->name,
            ],
            'location' => [
                'name' => $this->location->name,
            ],
            'carousel' => FileResource::collection($this->mediaFor('carousel')),
            'liaison' => new LiaisonResource($this->liaison),
        ];
    }
}
