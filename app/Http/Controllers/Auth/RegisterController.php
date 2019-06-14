<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Factory;

class RegisterController extends Controller
{
    /**
     * Auth factory
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * User model
     * @var \App\Models\User
     */
    protected $users;

    /**
     * Create a new controller instance
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @param  \App\Models\User                   $users
     * @return void
     */
    public function __construct(Factory $auth, User $users)
    {
        $this->auth  = $auth;
        $this->users = $users;
    }

    /**
     * Perform registration
     * @param  \App\Http\Requests\RegisterRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function register(RegisterRequest $request)
    {
        $data             = $request->validated();
        $data['password'] = bcrypt($request->get('password'));

        $user = $this->users->create($data);

        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'access_token' => $this->auth->fromUser($user),
                    'token_type'   => 'bearer',
                    'expires_in'   => $this->auth->factory()->getTTL() * 60,
                ],
            ]);
    }
}
