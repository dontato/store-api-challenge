<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Tests\TestCase;

class PasswordRecoveryTest extends TestCase
{
    /**
     * Test login endpoint
     *
     * @return void
     */
    public function testRemindEndpoint()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/password/remind', [
            'email' => $user->email,
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
        $user = factory(User::class)->create();

        $tokens = new DatabaseTokenRepository(
            app('db')->connection(),
            app('hash'),
            config('auth.passwords.users.table'),
            config('app.key'),
            config('auth.passwords.users.expire')
        );

        $response = $this->postJson('/api/password/reset', [
            'email'                 => $user->email,
            'token'                 => $tokens->create($user),
            'password'              => 'Secret123!',
            'password_confirmation' => 'Secret123!',
        ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'success' => true,
        ]);
    }
}
