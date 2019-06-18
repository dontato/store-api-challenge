<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
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
     * @param  \App\Http\Requests\UpdateAccountRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function update(UpdateAccountRequest $request)
    {
        $data = array_except($request->validated(), 'password');

        if (
            $request->has('password') &&
            $password = $request->get('password')
        ) {
            $data['password'] = bcrypt($password);
        }

        $user = $this->auth->user();
        $user->fill($data);

        if ($user->save()) {
            return new UserResource($user->fresh());
        }

        return new JsonResponse(['error' => 'unable_to_save'], 422);
    }
}
