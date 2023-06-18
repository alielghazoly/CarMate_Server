<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountStoreRequest extends FormRequest
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
            'name' => 'required|unique:accounts,account_user_name',
            'phone' => 'required|numeric|unique:accounts,account_phone_number',
            'fcm_token' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [ 
            'name.required' => 'name is required',
            'phone.required' => 'phone is required',
            'name.unique' => 'name already taken',
            'phone.unique' => 'phone already taken',
            'phone.numeric' => 'phone must be a number',
            'fcm_token.required' => 'fcm_token is required',
        ];

    }

}
