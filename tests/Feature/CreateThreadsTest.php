<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function guests_cannot_see_the_create_thread_page()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory(User::class)->state('unconfirmed')->create();
        $this->signIn($user);

        $thread = make(Thread::class);
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('threads.index'))
            ->assertSessionHas('flash', "Vous devez d'abord confirmer votre adresse e-mail.");
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make(Thread::class);
        $response = $this->post(route('threads.store'), $thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Foo Title']);
        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(route('threads.store'), $thread->toArray())->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);

    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Some Title 24']);
        $thread = $this->postJson(route('threads.store'), $thread->toArray())->json();
        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);

    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->delete($thread->path())
            ->assertRedirect(route('login'));

        $this->signIn()
            ->delete($thread->path())
            ->assertStatus(403);;
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->deleteJson(url($thread->path()));
        $response->assertStatus(204);

        $this->assertDatabaseMissing(app(Thread::class)->getTable(), ['id' => $thread->id]);
        $this->assertDatabaseMissing(app(Reply::class)->getTable(), ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    public function publishThread(array $overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post(route('threads.store'), $thread->toArray());
    }
}
