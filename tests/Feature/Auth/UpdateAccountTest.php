<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class UpdateAccountTest extends TestCase
{
    /**
     * Test Register endpoint.
     *
     * @return void
     */
    public function testUpdateEndpoint()
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->putJson('/api/account', [
                'email'    => $user->email,
                'name'     => "{$user->name} 2",
                'password' => 'Secret123!',
            ]);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'email' => $user->email,
            'name'  => $user->name,
        ]);

        $this->assertTrue($user->exists);
    }

    /**
     * Test Register endpoint.
     *
     * @return void
     */
    public function testUpdateUniqueEmailEndpoint()
    {
        $first_user  = factory(User::class)->create();
        $second_user = factory(User::class)->create();

        $response = $this
            ->actingAs($first_user, 'api')
            ->putJson('/api/account', [
                'email' => $second_user->email,
                'name'  => $first_user->name
            ]);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            'email' => [
                str_replace(':attribute', 'email', __('validation.unique')),
            ],
        ]);
    }
}
