<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required',
            'user_phone' => 'required',
            'user_fcm_token' => 'required'
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
            'user_name.required' => 'user_name is required',
            'user_phone.required' => 'user_phone is required',
            'user_name.unique' => 'user_name already taken',
            'user_phone.unique' => 'user_phone already taken',
            'user_phone.numeric' => 'user_phone must be a number',
            'user_fcm_token.required' => 'user_fcm_token is required',
        ];

    }

}
