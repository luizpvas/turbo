<?php

use Faker\Generator as Faker;
use App\Models\Plugins\BlogPost;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'website_id' => function () {
            return factory('App\Models\Website')->create()->id;
        },
        'title' => $faker->sentence(5),
        'slug' => $faker->unique()->slug,
        'body_html' => '<div>Grass city</div>',
        'body_text' => 'Grass city',
        'published_at' => now()
    ];
});
