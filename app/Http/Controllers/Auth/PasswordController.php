<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RemindPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

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

}
