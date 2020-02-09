<?php

namespace App\Http\Resources;

use App\MagicalKenya\Traits\HasFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'external_url' => $this->external_url,
            'qr_code' => new FileResource($this->mediaFor('qr_code')->first()),
            'carousel' => FileResource::collection($this->mediaFor('carousel')),
        ];
    }
}
