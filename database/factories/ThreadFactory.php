<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Channel, Thread, User};
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class);
        },
        'channel_id' => function () {
            return factory(Channel::class);
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
