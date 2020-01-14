<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use App\Location;
use App\TouristExperience;
use Faker\Generator as Faker;

$factory->define(TouristExperience::class, function (Faker $faker) {
    return [
        'location_id' => factory(Location::class)->create(),
        'activity_id' => factory(Activity::class)->create(),
        'description' => $faker->sentence(12),
    ];
});
