<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// Gestión del perfil propio del usuario autenticado.
// 'me'     → vista de resumen con sus coches y favoritos (solo lectura)
// 'edit'   → formulario de edición de datos personales
// 'update' → guarda los cambios (resetea email_verified_at si cambia el email)
// 'destroy'→ elimina la cuenta tras confirmar la contraseña
class ProfileController extends Controller
{
    // Carga relaciones con eager loading para evitar N+1 queries en la vista
    public function me(Request $request): View
    {
        $user = $request->user()->load([
            'cars.maker',
            'cars.model',
            'cars.primaryImage',
            'favouriteCars.maker',
            'favouriteCars.model',
            'favouriteCars.primaryImage',
        ]);

        return view('profile.me', compact('user'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->authorize('update', $request->user());

        $request->user()->fill($request->validated());

        // Si el email cambia, hay que re-verificar — se anula la verificación anterior
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', $request->user());

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}


