<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_thread()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_to_thread()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->fresh()->subscriptions);
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}

