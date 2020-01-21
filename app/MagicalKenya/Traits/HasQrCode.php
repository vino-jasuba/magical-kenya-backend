<?php

namespace App\MagicalKenya\Traits;

use App\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait HasQrCode
{
    public static function bootHasQrCode()
    {
        static::created(function ($model) {
            // generate svg image
            $qrCode = QrCode::size(300)->generate($model->qrContent);

            // save qr code to filesystem
            $filePath = 'files/' . Str::slug($model->name) . '.svg';
            Storage::disk('public')->put($filePath, $qrCode);

            // create media object for qr code
            $media = new Media([
                'file_type' => 'text/svg',
                'description' => $model->name,
                'file_path' => $filePath,
                'use_case' => 'qr_code',
            ]);

            // associate $model with $media object
            $model->media()->save($media);
        });
    }
}
