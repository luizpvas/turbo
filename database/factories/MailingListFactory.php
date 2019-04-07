<?php

use App\Models\User;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(App\Models\Plugins\MailingList::class, function (Faker $faker) {
    return [
        'website_id' => function () {
            return factory(Website::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->unique()->word,
    ];
});
