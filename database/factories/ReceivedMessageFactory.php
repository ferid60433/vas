<?php

use Faker\Generator as Faker;

$factory->define(Vas\ReceivedMessage::class, function (Faker $faker) {
    return [
        'address' => ''.$faker->randomNumber(8, true),
        'message' => $faker->paragraphs(3, true),
    ];
});
