<?php

namespace App\Http\Repositories;

use App\Media;
use App\Activity;
use App\Location;
use App\TouristExperience;
use Illuminate\Http\Request;
use App\Http\Contracts\InteractsWithMediaContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MediaRepository implements InteractsWithMediaContract
{
    /**
     * @inheritDoc
     */
    public function uploadFile(Request $request): Collection
    {
        $files = $request->file('files');
        $uploadedMedia = [];

        foreach ($files as $index => $file) {
            $mimeType = $file->getClientMimeType();
            $path = Storage::disk('public')->put('files', $file);

            $mediaInstance = new Media([
                'file_type' => $mimeType,
                'description' => $request->description[$index],
                'file_path' => $path,
                'use_case' => $request->use_case,
            ]);

            $model = config('magical_kenya.model_mappings')[$request->target_type];
            $uploadedMedia[] = $model::findOrFail($request->target_key)->media()->save($mediaInstance);
        }

        return collect($uploadedMedia);
    }

    /**
     * @inheritDoc
     */
    public function updateFileMetadata(\Illuminate\Http\Request $request, \App\Media $media): \App\Media
    {
        $media->fill($request->only(['description', 'use_case']));
        $media->save();
        return $media;
    }

    /**
     * @inheritDoc
     */
    public function deleteFile(Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        $media->delete();
    }
}
