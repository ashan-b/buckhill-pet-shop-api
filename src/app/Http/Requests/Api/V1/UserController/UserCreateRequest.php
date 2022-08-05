<?php

namespace App\Http\Requests\Api\V1\UserController;

use App\Http\Traits\ResponseGenerator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreateRequest extends FormRequest
{
    use ResponseGenerator;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'confirmed|min:8',
            'address_title' => 'required',
            'phone_number' => 'required',
            'is_marketing' => 'boolean'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->sendError('Validation errors', $validator->errors(), null, 422)
        );
    }
}
