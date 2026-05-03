<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// CRUD de usuarios — solo accesible para administradores (middleware rol:admin)
class UserController extends Controller
{
    // Lista todos los usuarios paginados con conteo de coches
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::withCount('cars')->latest()->paginate(15);

        return view('admin.index', compact('users'));
    }

    // Muestra el perfil de un usuario con sus coches y favoritos
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load([
            'cars.maker', 'cars.model', 'cars.primaryImage',
            'favouriteCars.maker', 'favouriteCars.model', 'favouriteCars.primaryImage',
        ]);

        return view('admin.show', compact('user'));
    }

    // Formulario de edición del usuario
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.edit', compact('user'));
    }

    // Actualiza datos y rol del usuario — validación delegada a UserUpdateRequest
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->fill($request->validated());

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user)->with('status', 'user-updated');
    }

    // Elimina el usuario
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'user-deleted');
    }
}


