<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Observers\Trending;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Trending
     */
    private Trending $trending;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
    }



    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read ()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create(Thread::class);
        $this->call('get', $thread->path());

        $this->assertCount(1, $trending = $this->trending->get());
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}

