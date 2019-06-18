<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
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
        $auth->shouldUse('api');
        $this->auth  = $auth;
        $this->users = $users;
    }

    /**
     * Perform login
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = $this->auth->attempt($credentials)) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        return (new UserResource($this->auth->user()))
            ->additional([
                'meta' => [
                    'access_token' => $token,
                    'token_type'   => 'bearer',
                    'expires_in'   => $this->auth->factory()->getTTL() * 60,
                ],
            ])
            ->response()
            ->header('Authorization', $token);
    }

    /**
     * Get the authenticated User.
     * @return \App\Http\Resources\UserResource
     */
    public function me()
    {
        $user = $this->auth->user();
        return new UserResource($user);
    }

    /**
     * Refresh a token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return (new UserResource($this->auth->user()))
            ->additional([
                'meta' => [
                    'access_token' => $token = $this->auth->refresh(),
                    'token_type'   => 'bearer',
                    'expires_in'   => $this->auth->factory()->getTTL() * 60,
                ],
            ])
            ->response()
            ->header('Authorization', $token);
    }
}
