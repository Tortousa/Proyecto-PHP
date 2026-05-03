<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la autorización real la gestiona UserPolicy en el controlador
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            // ignore() evita error de email duplicado al editar el mismo usuario
            'email'    => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
            'phone'    => ['nullable', 'string', 'max:45'],
            'rol'      => ['nullable', 'in:admin,user'],
            // nullable: solo actualiza si se envía un valor nuevo
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ];
    }
}
