<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserCreated()
    {
        $email = $this->faker->email;
        $name  = $this->faker->name;

        $this->artisan('store:admin:create', [
            '--name'     => $name,
            '--email'    => $email,
            '--password' => 'password',
        ]);

        $user = User::where('email', $email)->first();

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->exists);
        $this->assertTrue($user->hasRole('admin'));
    }
}
