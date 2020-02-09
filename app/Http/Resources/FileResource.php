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
            'file_path' => $this->loadImageURL($this->file_type, $this->file_path),
            'use_case' => $this->use_case,
            'target_key' => $this->model_primary_key,
            'target_type' => strtolower(class_basename($this->model_type)),
        ];
    }

    private function loadImageURL(string $fileType, string $filePath)
    {
        // Imageflow cannot parse svg images, so we use the filesystem
        // to serve svg files
        if ($fileType == 'text/svg') {
            return asset('storage/' . $filePath);
        }

        // use configured imageflow server if present
        if (config('magical_kenya.use_imageflow')) {
            return config('magical_kenya.imageflow_base_url') . $filePath;
        }

        // otherwise use filesystem
        return asset('storage/' . $filePath);
    }
}
