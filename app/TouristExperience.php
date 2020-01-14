<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TouristExperience extends Model
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
}
