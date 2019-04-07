<?php

use App\Models\User;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
    return [
        'website_id' => function () {
            return factory(Website::class)->create()->id;
        },
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => 'avatar.png',
        'mime' => 'application/png',
        'size_in_bytes' => 1024,
        'url' => 'https://turboroute.app/avatar.png'
    ];
});
