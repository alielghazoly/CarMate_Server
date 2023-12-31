<?php

namespace App\Http\Requests\Brand;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandCreateRequest extends FormRequest
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
            'name' => 'required|unique:brands,brand_name',
            'image' => 'required||mimes:png,jpg'
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
            'name.required' => 'name is required',
            'image.required' => 'image is required',
            'image.mimes' => 'image must be of type jpg or png'
        ];

    }
}
