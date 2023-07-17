<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarCreateRequest extends FormRequest
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
            'device_id' => 'required|exists:devices,device_random_id',
            'model_id' => 'required|exists:models,model_id',
            'car_year' => 'required|date',
            'car_color' => 'required|string',
            'car_sim' => 'required|string',
            'car_image' => 'required||mimes:png,jpg'
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
            'device_id.exists' => 'Not an existing device id',
            'device_id.required' => 'device_id is required',
            'model_id.required' => 'model_id is required',
            'model_id.exists' => 'Not an existing model id',
            'car_year.required' => 'car_year is required',
            'car_year.date' => 'car_year must be of type date',
            'car_color.string' => 'car_color must be of type string',
            'car_sim.string' => 'car_sim must be of type string',
            'car_color.required' => 'car_color is required',
            'car_sim.required' => 'car_sim is required',
            'car_image.required' => 'car_image is required',
            'car_image.mimes' => 'car_image must be of type jpg or png'

        ];

    }
}
