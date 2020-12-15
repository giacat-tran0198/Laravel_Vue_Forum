<?php


use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post(route('replies.favorites', ['reply' => 1]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $this->post(route('replies.favorites', ['reply' => $reply->id]));
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_one()
    {
        $this->signIn();
        $reply = create(Reply::class);
        try {
            $this->post(route('replies.favorites', ['reply' => $reply->id]));
            $this->post(route('replies.favorites', ['reply' => $reply->id]));
        }catch (Exception $e){
            $this->fail("Pas à insérer deux fois le même enregistrements");
    }
        $this->assertCount(1, $reply->favorites);
    }
}
