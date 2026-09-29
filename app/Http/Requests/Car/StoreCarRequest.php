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

    // Describe cada campo del body para la documentación generada por Scribe.
    public function bodyParameters(): array
    {
        return [
            'maker_id'     => ['description' => 'ID de la marca del coche.', 'example' => 1],
            'model_id'     => ['description' => 'ID del modelo del coche.', 'example' => 1],
            'city_id'      => ['description' => 'ID de la ciudad donde se ubica el coche.', 'example' => 1],
            'car_type_id'  => ['description' => 'ID del tipo de carrocería.', 'example' => 1],
            'fuel_type_id' => ['description' => 'ID del tipo de combustible.', 'example' => 1],
            'year'         => ['description' => 'Año de fabricación.', 'example' => 2020],
            'price'        => ['description' => 'Precio del coche en euros.', 'example' => 15000],
            'mileage'      => ['description' => 'Kilometraje del coche.', 'example' => 80000],
            'vin'          => ['description' => 'Número de bastidor (VIN).', 'example' => 'WVWZZZ1KZAW000001'],
            'phone'        => ['description' => 'Teléfono de contacto del anuncio.', 'example' => '600123456'],
            'address'      => ['description' => 'Dirección donde se puede ver el coche.', 'example' => 'Calle Mayor 1'],
            'description'  => ['description' => 'Descripción libre del anuncio.', 'example' => 'Coche en perfecto estado, único dueño.'],
            'images'       => ['description' => 'Listado de imágenes del coche (opcional).'],
            'images.*'     => ['description' => 'Cada imagen: jpg, jpeg, png, gif o webp (máx. 5 MB).'],
        ];
    }
}
