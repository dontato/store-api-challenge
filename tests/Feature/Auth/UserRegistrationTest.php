<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use WithFaker;

    /**
     * Test Register endpoint.
     *
     * @return void
     */
    public function testRegisterEndpoint()
    {
        $email = $this->faker->email;
        $name  = $this->faker->name;

        $response = $this->postJson('/api/register', [
            'email'    => $email,
            'name'     => $name,
            'password' => 'Secret123!',
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'email' => $email,
            'name'  => $name,
        ]);

        $user = User::where('email', $email)->first();

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->exists);
    }
}
