<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TouristExperience extends Model implements Searchable
{
    use SoftDeletes;

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function liaison()
    {
        return $this->belongsTo(Liaison::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getSearchResult(): \Spatie\Searchable\SearchResult
    {
        return new SearchResult($this, $this->description, route('experiences.show', $this->id));
    }
}
