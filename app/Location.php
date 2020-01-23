<?php

namespace App;

use App\MagicalKenya\Traits\HasQrCode;
use App\MagicalKenya\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Location extends Model
{
    use SoftDeletes, HasQrCode, Sluggable;

    protected $guarded = [];

    public function experiences()
    {
        return $this->hasMany(TouristExperience::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function getQrContentAttribute() : string
    {
        return "geo:{$this->lat},{$this->lng}";
    }
}
