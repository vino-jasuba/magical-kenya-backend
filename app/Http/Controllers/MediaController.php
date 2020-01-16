<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Contracts\InteractsWithMediaContract;
use App\Http\Requests\MediaUpdateRequest;
use App\Http\Requests\MediaUploadRequest;
use App\Http\Resources\FileResource;
use App\Location;
use App\Media;
use App\TouristExperience;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $mediaRepository;

    public function __construct(InteractsWithMediaContract $interactsWithMediaContract)
    {
        $this->mediaRepository = $interactsWithMediaContract;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MediaUploadRequest $request)
    {
        $media = $this->mediaRepository->uploadFile($request);
        return (FileResource::collection($media))
            ->response()
            ->setStatusCode(201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $medium
     * @return \Illuminate\Http\Response
     */
    public function update(MediaUpdateRequest $request, Media $medium)
    {
        $updatedFile = $this->mediaRepository->updateFileMetadata($request, $medium);
        return new FileResource($updatedFile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $medium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $medium)
    {
        $this->mediaRepository->deleteFile($medium);
        return response('', Response::HTTP_NO_CONTENT);
    }
}
