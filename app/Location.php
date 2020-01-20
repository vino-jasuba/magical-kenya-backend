<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Location extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($location) {
            // generate svg image
            $qrCode = QrCode::size(300)->geo($location->lat, $location->lng);

            // save qr code to filesystem
            $filePath = 'files/' . Str::slug($location->name) . '.svg';
            Storage::disk('public')->put($filePath, $qrCode);

            // create media object for qr code
            $media = new Media([
                'file_type' => 'text/svg',
                'description' => $location->name,
                'file_path' => $filePath,
                'use_case' => 'qr_code',
            ]);

            // associate $location with $media object
            $location->media()->save($media);
        });
    }

    public function experiences()
    {
        return $this->hasMany(TouristExperience::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }
}
