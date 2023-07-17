<?php

namespace App\Http\Requests\Device;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeviceCreateRequest extends FormRequest
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
            'status' => 'required|in:generated,programmed,installed,uninstalled',
            'version' => 'required',
            'date' => 'required',
            'printed' => 'required|boolean',
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
            'status.required' => 'status is required',
            'version.required' => 'version is required',
            'date.required' => 'date is required',
            'status.in' => 'wrong status value',
            'printed.in' => 'printed is required',
            'printed.boolean' => 'wrong printed value',
        ];

    }
}
