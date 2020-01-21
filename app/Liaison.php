<?php

namespace App;

use App\MagicalKenya\Traits\HasQrCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Liaison extends Model
{
    use HasQrCode;

    protected $guarded = [];

    public function associatedExperiences()
    {
        return $this->hasMany(TouristExperience::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function getQrContentAttribute() : string
    {
        return "tel: {$this->phone_number}";
    }
}
