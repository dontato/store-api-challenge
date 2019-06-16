<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test login endpoint
     *
     * @return void
     */
    public function testLoginEndpoint()
    {
        $data = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email'    => $data->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $data->email,
            'name'  => $data->name,
        ]);
    }
}
