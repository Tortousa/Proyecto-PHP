<?php

return [
    'required'  => 'El campo :attribute es obligatorio.',
    'email'     => 'El campo :attribute debe ser una dirección de correo válida.',
    'min'       => ['string' => 'El campo :attribute debe tener al menos :min caracteres.'],
    'max'       => ['string' => 'El campo :attribute no puede tener más de :max caracteres.'],
    'unique'    => 'El :attribute ya está en uso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'numeric'   => 'El campo :attribute debe ser un número.',
    'integer'   => 'El campo :attribute debe ser un número entero.',
    'exists'    => 'El :attribute seleccionado no es válido.',
    'image'     => 'El campo :attribute debe ser una imagen.',
    'mimes'     => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'max'       => [
        'file'   => 'El archivo :attribute no puede pesar más de :max kilobytes.',
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],

    'attributes' => [
        'name'         => 'nombre',
        'email'        => 'correo electrónico',
        'password'     => 'contraseña',
        'phone'        => 'teléfono',
        'price'        => 'precio',
        'year'         => 'año',
        'mileage'      => 'kilometraje',
        'description'  => 'descripción',
        'address'      => 'dirección',
        'maker_id'     => 'marca',
        'model_id'     => 'modelo',
        'city_id'      => 'ciudad',
        'car_type_id'  => 'tipo de carrocería',
        'fuel_type_id' => 'combustible',
    ],
];
