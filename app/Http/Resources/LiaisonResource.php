<?php

namespace App\Http\Resources;

use App\MagicalKenya\Traits\HasFiles;
use Illuminate\Http\Resources\Json\JsonResource;

class LiaisonResource extends JsonResource
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
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'qr_code' => new FileResource($this->mediaFor('qr_code')->first()),
        ];
    }
}
