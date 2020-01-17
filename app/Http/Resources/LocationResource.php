<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'catchphrase' => $this->catchphrase,
            'description' => $this->description,
            'color_tag' => $this->color_tag,
            'icon' => $this->icon,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'background' => FileResource::collection($this->mediaFor('background')),
            'carousel' => FileResource::collection($this->mediaFor('carousel')),
        ];
    }

    private function mediaFor(string $useCase)
    {
        return $this->media()->useCase($useCase)->get();
    }
}
