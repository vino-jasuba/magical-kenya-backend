<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'file_type' => $this->file_type,
            'description' => $this->description,
            'file_path' => asset('storage/' . $this->file_path),
            'use_case' => $this->use_case,
            'target_key' => $this->model_primary_key,
            'target_type' => strtolower(class_basename($this->model_type)),
        ];
    }
}
