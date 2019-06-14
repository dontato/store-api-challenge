<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
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
