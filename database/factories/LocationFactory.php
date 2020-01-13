<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'catchphrase' => $faker->sentence,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'color_tag' => $faker->hexColor,
        'icon' => 'path/to/icon/file',
    ];
});
