<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

// Valida el body del endpoint POST /api/auth/register.
// Password::defaults() aplica las reglas mínimas configuradas en AppServiceProvider (longitud, etc.).
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    // Describe cada campo del body para la documentación generada por Scribe.
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Nombre completo del usuario.',
                'example'     => 'Iker Martínez',
            ],
            'email' => [
                'description' => 'Correo electrónico único. Se guarda en minúsculas.',
                'example'     => 'iker@example.com',
            ],
            'phone' => [
                'description' => 'Teléfono de contacto del usuario.',
                'example'     => '600123456',
            ],
            'password' => [
                'description' => 'Contraseña. Debe cumplir las reglas mínimas de seguridad.',
                'example'     => 'Password123',
            ],
            'password_confirmation' => [
                'description' => 'Confirmación de la contraseña. Debe coincidir con password.',
                'example'     => 'Password123',
            ],
        ];
    }
}
