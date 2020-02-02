<?php

namespace App;

use App\MagicalKenya\Traits\HasQrCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasQrCode;

    protected $fillable = ['start_date', 'end_date', 'external_url', 'title'];

    // protected $dates = ['start_date', 'end_date'];

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('start_date', '>=', date('Y-m-d'));
    }

    public function scopePast($query)
    {
        return $query->whereDate('end_date', '<=', date('Y-m-d'));
    }

    public function getNameAttribute()
    {
        return $this->title;
    }

    public function getQrContentAttribute()
    {
        return $this->external_url;
    }
}
