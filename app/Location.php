<?php

namespace App;

use App\MagicalKenya\Traits\HasQrCode;
use App\MagicalKenya\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Location extends Model implements Searchable
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

    public function getSearchResult(): \Spatie\Searchable\SearchResult
    {
        return new SearchResult($this, $this->name, route('locations.show', $this->slug));
    }
}
