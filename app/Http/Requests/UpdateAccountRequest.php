<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user('api');

        return [
            'name'     => ['required', 'string'],
            'password' => ['string', 'nullable'],
            'email'    => [
                'required', 'string',
                (new Unique('users', 'email'))
                    ->ignore($user->id),
            ],
        ];
    }
}