<?php

use Faker\Generator as Faker;

$factory->define(Vas\Subscriber::class, function (Faker $faker) {
    return [
        'address' => ''.$faker->randomNumber(8, true),
        'service_id' => function () {
            return factory(Vas\Service::class)->create()->id;
        },
    ];
});
