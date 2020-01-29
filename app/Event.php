<?php

namespace App;

use App\MagicalKenya\Traits\HasQrCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasQrCode;

    protected $guarded = [];

    protected $dates = ['due_date'];

    public function media()
    {
        return $this->morphMany(Media::class, 'modelable', 'model_type', 'model_primary_key', 'id');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('due_date', '>=', date('Y-m-d'));
    }

    public function scopePast($query)
    {
        return $query->whereDate('due_date', '<=', date('Y-m-d'));
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
