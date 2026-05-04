<?php

namespace App\Http\Controllers\Web\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Muestra el formulario de registro
    public function create(): View
    {
        return view('auth.register');
    }

    // Crea la cuenta, dispara el evento de bienvenida y hace login automático
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // El evento dispara SendWelcomeMail → SendWelcomeEmailJob (cola)
        UserRegistered::dispatch($user);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
