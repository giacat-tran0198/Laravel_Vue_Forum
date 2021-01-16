<?php

namespace Tests\Unit;


use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
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
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();
        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
            'body' => 'Foobar',
            'user_id' => 999,
        ]);


        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);
        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create(Thread::class);
        $thread->subscribe($userId = 1);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_to()
    {
        $thread = create(Thread::class);
        $thread->subscribe($userId = 1);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
        $thread->unsubscribe($userId = 1);
        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = create(Thread::class);
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();
        $thread = create(Thread::class);
        tap(auth()->user(), fn(User $user) => [
            $this->assertTrue($thread->hasUpdatesFor($user)),
            $user->read($thread),
            $this->assertFalse($thread->hasUpdatesFor($user)),
        ]);
    }

    /** @test */
    public function a_thread_records_each_visit()
    {
        $thread = make(Thread::class, ['id' => 1]);
        $thread->resetVisit();
        $this->assertEquals(0, $thread->visits());
        $thread->recordVisit();
        $this->assertEquals(1, $thread->visits());
        $thread->recordVisit();
        $this->assertEquals(2, $thread->visits());
    }
}
