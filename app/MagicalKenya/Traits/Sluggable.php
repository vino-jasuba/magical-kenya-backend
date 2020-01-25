<?php

namespace App\MagicalKenya\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::saving(function ($model) {
            // generate slug
            $model->slug = Str::slug(str_replace('&', 'and', $model->name));
        });
    }

    public function resolveRouteBinding($value)
    {
        return $this->where('slug', $value)->orWhere('id', intval($value))->firstOrFail();
    }
}
