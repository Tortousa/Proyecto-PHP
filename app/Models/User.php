<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'rol',
        'phone',
        'google_id',
        'facebook_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'rol',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // =====================
    // Roles
    // =====================

    public function hasRole(string $rol): bool
    {
        return $this->rol === $rol;
    }

    public function hasAnyRole(string ...$roles): bool
    {
        return in_array($this->rol, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    // =====================
    // Relaciones
    // =====================

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function favouriteCars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'favourite_cars');
    }
}
