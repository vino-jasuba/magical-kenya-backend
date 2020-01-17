<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'file_type' => $faker->mimeType,
        'description' => $faker->sentence,
        'file_path' => 'fake/path/to/file.extension',
        'use_case' => $faker->randomElement(['background', 'carousel']),
    ];
});
