<?php

namespace App;

use App\MagicalKenya\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Activity extends Model implements Searchable
{
    use SoftDeletes, Sluggable;

    protected $fillable = ['name', 'description', 'color_tag', 'catchphrase'];

    public function experiences()
    {
        return $this->hasMany(TouristExperience::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function getSearchResult(): \Spatie\Searchable\SearchResult
    {
        return new SearchResult($this, $this->name, route('activities.show', $this->slug));
    }
}
