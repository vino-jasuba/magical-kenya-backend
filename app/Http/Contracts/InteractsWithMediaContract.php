<?php


namespace App\Http\Contracts;


use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface InteractsWithMediaContract
{
    /**
     * Upload files from request and save the details in the Media model
     * The files are uploaded with the following metadata
     * description: string describing the uploaded file
     * target_key: primary key of the model that the file belongs to
     * target_model: model the file belongs to
     * @param Request $request
     * @return Collection
     */
    public function uploadFile(Request $request) : Collection;

    /**
     * Remove associated file from filesystem
     * Delete the media file from database
     * @param Media $media
     * @return mixed
     */
    public function deleteFile(Media $media);

    /**
     * Update media descriptions and use cases
     *
     * @param Request $request
     * @param Media $media
     * @return Media
     */
    public function updateFileMetadata(Request $request, Media $media) : Media;
}