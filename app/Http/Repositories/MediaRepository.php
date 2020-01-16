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
        $files = collect($request->file('files'));

        $media = $files->map(function ($file) use ($request) {
            $mimeType = $file->getClientMimeType();
            $path = Storage::disk('public')->put('files', $file);

            $media = new Media([
                'file_type' => $mimeType,
                'description' => $request->description,
                'file_path' => $path,
                'use_case' => $request->use_case,
            ]);

            $model = config('magical_kenya.model_mappings')[$request->target_type];
            return $model::findOrFail($request->target_key)->media()->save($media);
        });

        return $media;
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
        // TODO: Implement deleteFile() method.
    }
}
