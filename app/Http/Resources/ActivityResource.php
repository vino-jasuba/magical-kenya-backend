<?php

namespace App\Http\Resources;

use App\MagicalKenya\Traits\HasFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'title' => $this->title,
            'catchphrase' => $this->catchphrase,
            'description' => $this->description,
            'carousel' => FileResource::collection($this->mediaFor('carousel')),
            'background' => FileResource::collection($this->mediaFor('background')),
        ];
    }
}
