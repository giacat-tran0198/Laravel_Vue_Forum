<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/somme-channel/1/replies', [])
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_many_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->assertDatabaseHas(app(Reply::class)->getTable(), ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()
            ->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = create(Reply::class);
        $this->delete(route('replies.destroy', $reply->id))
            ->assertRedirect(route('login'));

        $this->signIn()
            ->delete(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply->id))
            ->assertStatus(302);

        $this->assertDatabaseMissing(app(Reply::class)->getTable(), ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthorized_users_cannot_update_replies()
    {
        $reply = create(Reply::class);
        $this->patch(route('replies.destroy', $reply->id))
            ->assertRedirect(route('login'));

        $this->signIn()
            ->patch(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $updatedReply = 'Modification';
        $this->patch(route('replies.update', $reply->id), ['body' => $updatedReply]);
        $this->assertDatabaseHas(app(Reply::class)->getTable(), ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => 'yahoo customer support']);
        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertStatus(422);
    }
}
