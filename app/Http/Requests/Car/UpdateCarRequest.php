<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCarRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maker_id'   => ['required', 'exists:makers,id'],
            'model_id'   => ['required', 'exists:models,id'],
            'city_id'    => ['required', 'exists:cities,id'],
            'car_type_id'=> ['required', 'exists:car_types,id'],
            'fuel_type_id'=> ['required', 'exists:fuel_types,id'],
            'year'       => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'price'      => ['required', 'numeric', 'min:0'],
            'mileage'    => ['required', 'integer', 'min:0'],
            'vin'        => ['required', 'string', 'max:255'],
            'phone'      => ['required', 'string', 'max:45'],
            'address'    => ['required', 'string', 'max:255'],
            'description'=> ['nullable', 'string'],
        ];
    }
}
