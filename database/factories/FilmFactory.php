<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Film;
use Faker\Generator as Faker;

$factory->define(Film::class, function (Faker $faker) {
    return [
        'country_id' => factory(App\Country::class),
        'name' => $faker->company,
        'slug' => $faker->slug,
        'description' => $faker->realText(),
        'release_date' => $faker->dateTime(), // password
        'rating' => $faker->randomDigit(),
        'price' => $faker->randomNumber(2),
        'photo' => $faker->imageUrl(),
    ];
});
