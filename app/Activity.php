<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function experiences()
    {
        return $this->hasMany(TouristExperience::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }
}
