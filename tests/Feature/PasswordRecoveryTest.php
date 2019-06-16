<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;

class PasswordRecoveryTest extends TestCase
{
    /**
     * Test login endpoint
     *
     * @return void
     */
    public function testRemindEndpoint()
    {
        $data = factory(User::class)->create();

        $response = $this->postJson('/api/password/remind', [
            'email' => $data->email,
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'success' => true,
        ]);
    }
    /**
     * Test login endpoint
     *
     * @return void
     */
    public function testResetEndpoint()
    {
        $user  = factory(User::class)->create();
        $token = new DatabaseTokenRepository(
            app('db')->connection(),
            app('hash'),
            config('app.key'),
            config('auth.passwords.users.table'),
            config('auth.passwords.users.expire')
        );

        $response = $this->postJson('/api/password/reset', [
            'email'                 => $user->email,
            'token'                 => $token,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'success' => true,
        ]);
    }
}
