<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !!$this->user('api');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'items'            => ['required', 'array'],
            'items.*.uuid'     => [
                'required', 'string',
                (new Exists('products', 'uuid'))
                    ->where(function ($query) {
                        $query->where('is_available', 1);
                    }),
            ],
            'items.*.quantity' => ['required', 'numeric'],
        ];
    }
}
