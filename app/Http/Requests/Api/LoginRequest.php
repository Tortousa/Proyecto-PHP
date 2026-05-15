<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

// Valida el body del endpoint POST /api/auth/login.
// La verificación de credenciales se hace en AuthController::login() con Auth::attempt().
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
