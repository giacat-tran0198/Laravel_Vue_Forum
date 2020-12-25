<?php

namespace Tests\Unit;


use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use phpDocumentor\Reflection\Types\This;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Collection|\Illuminate\Database\Eloquent\Model
     */
    private $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $this->assertEquals(
            route('threads.show', ['channel' => $this->thread->channel->slug, 'thread' => $this->thread->id]),
            url($this->thread->path())
        );
    }

    /** @test */
    public function a_thread_has_reply()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);
        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create(Thread::class);
        create(Reply::class, ['thread_id' => $thread->id], 2);
        $response = $this->getJson($thread->path().'/replies')->json();
        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
