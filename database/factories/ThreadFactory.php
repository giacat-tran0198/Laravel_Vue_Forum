<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Channel, Thread, User};
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => fn() => factory(User::class),
        'channel_id' => fn() => factory(Channel::class),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'visits' => 0,
    ];
});
