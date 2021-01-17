<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
        event(new Registered(create(User::class)));
        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_fully_confirm_their_email_addresses()
    {
        $this->post("/register", [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ]);

        $user = User::whereName('John')->first();
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        $this->get(route('register.confirm', ['token' => $user->confirmation_token]));
        $this->assertTrue($user->fresh()->confirmed);

    }
}
