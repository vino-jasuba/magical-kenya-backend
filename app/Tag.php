<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function experiences()
    {
        return $this->morphedByMany(TouristExperience::class, 'taggable');
    }
}
