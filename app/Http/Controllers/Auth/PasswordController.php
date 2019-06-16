<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RemindPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    /**
     * @param \Illuminate\Contracts\Auth\PasswordBrokerFactory $auth
     */
    protected $passwords;

    /**
     * Create a new controller instance
     * @param  \Illuminate\Contracts\Auth\PasswordBrokerFactory $factory
     */
    public function __construct(PasswordBrokerFactory $passwords)
    {
        $this->passwords = $passwords;
    }

    /**
     * Send Password reminder.
     * @param  \App\Http\Requests\Api\V1\RemindPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remind(RemindPasswordRequest $request)
    {
        $response = $this->passwords->broker()
            ->sendResetLink($request->only('email'));

        $success = false;

        if ($response == Password::RESET_LINK_SENT) {
            $success = true;
        }

        return new JsonResponse(['success' => true]);
    }

    /**
     * Reset the user password.
     * @param  \App\Http\Requests\Api\V1\ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->passwords->broker()->reset(
            $request->only([
                'email', 'password', 'password_confirmation', 'token',
            ]),
            function ($user, $password) {
                $user
                    ->forceFill([
                        'password'       => bcrypt($password),
                        'remember_token' => Str::random(60),
                    ])
                    ->save();
            }
        );

        $success = false;

        if ($response == Password::PASSWORD_RESET) {
            $success = true;
        }

        return new JsonResponse(compact('success'), $success ? 200 : 422);
    }
}
