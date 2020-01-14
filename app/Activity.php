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
}
