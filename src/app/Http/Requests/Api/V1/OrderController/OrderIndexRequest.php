<?php

namespace App\Http\Requests\Api\V1\OrderController;

use App\Http\Traits\ResponseGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderIndexRequest extends FormRequest
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
            'sortBy' => Rule::in(['id', 'uuid','amount']),
            'desc' => Rule::in(['true', 'false']),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->sendError('Validation errors', $validator->errors(), null, 422)
        );
    }
}
