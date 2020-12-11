<?php

use App\Models\{Reply, Thread, User};
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            factory(Reply::class)
                ->create([
                    'thread_id' => Thread::all()->random(),
                    'user_id' => User::all()->random()
                ]);
        }

    }
}
