<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'start_date' => $faker->dateTime,
        'end_date' => $faker->dateTime,
        'external_url' => $faker->url,
    ];
});
