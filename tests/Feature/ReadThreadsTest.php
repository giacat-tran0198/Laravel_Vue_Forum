<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }


    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);
        $this->get(route('threads.index.channel', ['channel' => $channel->slug]))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->withoutExceptionHandling();
        $this->signIn(create(User::class, ['name' => 'Cat']));
        $threadByCat = create(Thread::class, ['user_id' => auth()->id()]);
        $threadNotByCat = create(Thread::class);

        $this->get(route('threads.index', ['by' => 'Cat']))
            ->assertSee($threadByCat->title)
            ->assertDontSee($threadNotByCat->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithNoReplies = $this->thread;

        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson(route('threads.index', ['popular' => 1]))->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
