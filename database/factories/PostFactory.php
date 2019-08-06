<?php

use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->text(1000),
        'status' => rand(0,1),
        'user_id' => 1
    ];
});
