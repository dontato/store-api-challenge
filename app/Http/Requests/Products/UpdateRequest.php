<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->hasPermissionTo('edit products');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => ['required', 'string'],
            'sku'          => ['required', 'string'],
            'description'  => ['required', 'string'],
            'price'        => ['required', 'numeric'],
            'stock'        => ['required', 'numeric'],
            'is_available' => ['required', 'boolean'],
        ];
    }
}
