<?php

namespace App\Http\Requests\Api\V1\OrderController;

use App\Http\Traits\ResponseGenerator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderCreateRequest extends FormRequest
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
            'products' => 'required|string',
            'address' => 'required|string',
            'order_status_uuid' => 'required|exists:order_statuses,uuid',
            'payment_uuid' => 'required|exists:payments,uuid',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->sendError('Validation errors', $validator->errors(), null, 422)
        );
    }
}
