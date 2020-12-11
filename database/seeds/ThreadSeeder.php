<?php

use Illuminate\Database\Seeder;
use App\Models\Thread;
class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Thread::class, 20)->create();
    }
}
