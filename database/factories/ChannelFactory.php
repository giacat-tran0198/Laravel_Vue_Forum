<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    $slug = $faker->unique()->slug(2);
    return [
        'name' => str_replace('-', ' ', $slug),
        'slug' => $slug,
    ];
});
