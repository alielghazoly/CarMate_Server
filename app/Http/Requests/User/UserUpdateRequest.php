<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_fcm_token' => 'required',
            'new_fcm_token' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $allErrors = $validator->errors();
        $firstError = reset($allErrors);
        throw new HttpResponseException(response()->json([
            'message'   => reset($firstError)[0],
            'isSuccess'   => false,
            'statusCode'   => 403,
        ]));
    }

    public function messages()
    {
        return [ 
            'old_fcm_token.required' => 'old_fcm_token is required',
            'new_fcm_token.required' => 'new_fcm_token is required',
        ];
    }
}
