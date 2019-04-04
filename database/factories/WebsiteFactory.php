<?php

use App\Models\User;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(Website::class, function (Faker $faker) {
    return [
        'owner_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->domainWord,
        'domain' => $faker->unique()->domainName,
        'subdomain' => $faker->domainWord
    ];
});
