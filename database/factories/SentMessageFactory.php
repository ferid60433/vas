<?php

use Faker\Generator as Faker;

$factory->define(Vas\SentMessage::class, function (Faker $faker) {
    return [
        'address' => ''.$faker->randomNumber(8, true),
        'message' => $faker->paragraphs(3, true),
        'delivery_status' => $faker->randomElement([0, 1]),
        'service_id' => function () {
//            return factory(Vas\Service::class)->create()->id;
            return Vas\Service::all()->random()->id;
        },
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = null)
    ];
});
