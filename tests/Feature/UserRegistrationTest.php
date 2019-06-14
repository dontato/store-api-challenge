<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = factory(User::class)->make();

        $response = $this->postJson('/api/register', [
            'email'    => $data->email,
            'name'     => $data->name,
            'password' => 'password',
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'email' => $data->email,
            'name'  => $data->name,
        ]);

        $user = User::where('email', $data->email)->first();

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->exists);
    }
}
