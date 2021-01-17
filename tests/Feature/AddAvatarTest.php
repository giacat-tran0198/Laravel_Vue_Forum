<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function only_members_can_add_avatars()
    {
        $this->withExceptionHandling();
        $this->postJson('api/users/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling()
            ->signIn()
            ->postJson(route('user.store.ava', auth()->user()), [
                'avatar' => 'not-an-image',
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->postJson(route('user.store.ava', auth()->user()), [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('storage/avatars/'.$file->hashName()), asset(auth()->user()->avatar_path));

        Storage::disk('public')
            ->assertExists('avatars/' . $file->hashName());
    }
}

