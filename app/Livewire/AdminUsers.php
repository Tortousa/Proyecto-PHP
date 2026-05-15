<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

// Componente Livewire para el panel de administración de usuarios.
// Permite buscar, editar nombre/email/rol y eliminar usuarios en tiempo real.
// Solo accesible desde rutas protegidas con middleware rol:admin.
class AdminUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editingId = null;
    public string $editName = '';
    public string $editEmail = '';
    public string $editRol = 'user';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function edit(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->editingId  = $userId;
        $this->editName   = $user->name;
        $this->editEmail  = $user->email;
        $this->editRol    = $user->rol;
    }

    public function save(): void
    {
        $this->validate([
            'editName'  => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:users,email,' . $this->editingId,
            'editRol'   => 'required|in:user,admin',
        ]);

        User::findOrFail($this->editingId)->update([
            'name'  => $this->editName,
            'email' => $this->editEmail,
            'rol'   => $this->editRol,
        ]);

        $this->editingId = null;
    }

    public function cancel(): void
    {
        $this->editingId = null;
    }

    public function delete(int $userId): void
    {
        abort_unless(auth()->user()?->hasRole('admin'), 403);
        User::findOrFail($userId)->delete();
    }

    public function render()
    {
        $users = User::when($this->search, fn($q) =>
            $q->where('name', 'like', "%{$this->search}%")
              ->orWhere('email', 'like', "%{$this->search}%")
        )->paginate(10);

        return view('livewire.admin-users', compact('users'));
    }
}
