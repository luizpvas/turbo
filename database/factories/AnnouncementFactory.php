<?php

use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(App\Models\Plugins\Announcement::class, function (Faker $faker) {
    return [
        'website_id' => function () {
            return factory(Website::class)->create()->id;
        },
        'title' => $faker->word,
        'body' => $faker->sentence
    ];
});
