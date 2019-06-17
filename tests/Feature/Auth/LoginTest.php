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

    /**
     * Test login with wrong credentials
     *
     * @return void
     */
    public function testLoginFail()
    {
        $data = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email'    => $data->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test refresh token
     *
     * @return void
     */
    public function testRefreshToken()
    {
        $user = factory(User::class)->create();
        $token = $this->app['auth']->login($user);

        $response = $this->actingAs($user)
            ->postJson('/api/auth/refresh', compact('token'));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $user->email,
            'name'  => $user->name,
        ]);
    }

    /**
     * Test refresh token
     *
     * @return void
     */
    public function testMeEndpoint()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/me');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $user->email,
            'name'  => $user->name,
        ]);
    }
}
