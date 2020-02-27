<?php

namespace App\Http\Resources;

use App\MagicalKenya\Traits\HasFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'catchphrase' => $this->catchphrase,
            'description' => $this->description,
            'color_tag' => $this->color_tag,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'experiences_count' => $this->experiences_count,
            'background' => FileResource::collection($this->mediaFor('background')),
            'carousel' => FileResource::collection($this->mediaFor('carousel')),
            'qr_code' => new FileResource($this->mediaFor('qr_code')->first())
        ];
    }
}
