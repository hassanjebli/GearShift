<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreCarRequest extends FormRequest
{
//    protected $stopOnFirstFailure = true;
//    protected $redirect = '/';
//    protected $redirectRoute = 'car.index';

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id' => 'required|exists:makers,id',
            'model_id' => 'required|exists:models,id',
            'year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'price' => 'required|integer|min:0',
            'vin' => 'required|string|size:17',
            'mileage' => 'required|integer|min:0',
            'car_type_id' => 'required|exists:car_types,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'phone' => 'required|string|min:9',
            'description' => 'nullable|string',
            'published_at' => 'nullable|string',
            'features' => 'array',
            'features.*' => 'string',
            'images' => 'array',
            'images.*' => File::image()->max(2048)
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required',
        ];
    }

    public function attributes()
    {
        return [
            'maker_id' => 'maker',
            'model_id' => 'model',
            'car_type_id' => 'car type',
            'fuel_type_id' => 'fuel type',
            'city_id' => 'city'
        ];
    }

//    protected function prepareForValidation()
//    {
//        $this->merge([
//            'vin' => strtoupper($this->vin)
//        ]);
//    }

    protected function passedValidation()
    {
        $this->replace([
            'vin' => strtoupper($this->vin)
        ]);
    }
}
