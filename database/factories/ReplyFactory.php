<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Reply, Thread, User};
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(),
        'thread_id' => fn () => factory(Thread::class),
        'user_id' => fn ()  => factory(User::class),
    ];
});
