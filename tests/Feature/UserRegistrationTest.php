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
        $user = factory(User::class)->make();

        $response = $this->postJson('/api/register', [
            'email'    => $user->email,
            'name'     => $user->name,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $user->email,
            'name'  => $user->name,
        ]);
    }
}
