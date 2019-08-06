<?php

use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    $title = $faker->sentence;
    $friendly_url = \App\Helpers\Functions::friendlyUrl($title);

    return [
        'title' => $title,
        'friendly_url' => $friendly_url,
        'body' => $faker->text(1000),
        'status' => rand(0,1),
        'user_id' => 1
    ];
});
