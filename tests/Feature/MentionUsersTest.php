<?php


namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create(User::class, ['name' => 'JohnDoe']);
        $this->signIn($john);

        $jane = create(User::class, ['name' => 'JaneDoe']);

        $thread = create(Thread::class);
        $reply = make(Reply::class, [
            'body' => 'Hey @JaneDoe check this out.'
        ]);
        $this->postJson( $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);
    }
}
