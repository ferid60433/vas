<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Vas\Service::class, function (Faker $faker) {
    return [
        'letter' => Str::substr($faker->word, 0, 5),
        'code' => $faker->word,
        'confirmation_message' => $faker->paragraph,
    ];
});
