<?php

use Faker\Generator as Faker;

$factory->define(Vas\Service::class, function (Faker $faker) {
    return [
        'letter' => $faker->randomLetter,
        'code' => $faker->word,
        'confirmation_message' => $faker->paragraph,
        'mandatory' => $faker->boolean,
    ];
});
