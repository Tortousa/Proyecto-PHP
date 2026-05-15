<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

// Valida los datos del formulario de creación de un anuncio de coche.
// La autorización real se delega a CarPolicy::create() desde el controlador.
class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ];
    }
}
