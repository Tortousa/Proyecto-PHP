<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'maker_id',
        'model_id',
        'year',
        'price',
        'vin',
        'mileage',
        'car_type_id',
        'fuel_type_id',
        'user_id',
        'city_id',
        'address',
        'phone',
        'description',
        'published_at',
    ];

    public function features(): HasOne
    {
        return $this->hasOne(CarFeatures::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(CarImages::class)
            ->oldestOfMany('position');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImages::class);
    }

    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    public function favouredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourite_cars', 'car_id', 'user_id');
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Model::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');;
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Scopes para filtrar anuncios

    // 1. Scope Simple: Filtrar por tipo de combustible
    // Dificultad: Baja. Es un WHERE directo.
    public function scopeOfFuelType($query, $fuelTypeId)
    {
        return $query->where('fuel_type_id', $fuelTypeId);
    }

    // 2. Scope Complejo: Filtrar por Marca (Relación 1:N)
    // Dificultad: Media. Usa 'whereHas' para buscar en otra tabla.
    public function scopeByMaker($query, $makerName)
    {
        return $query->whereHas('maker', function ($q) use ($makerName) {
            $q->where('name', 'like', '%' . $makerName . '%');
        });
    }

    // 3. Scope Complejo: Búsqueda por ubicación (Relación a través de Ciudad -> Estado)
    // Dificultad: Alta. Filtra por una relación de la relación.
    public function scopeInState($query, $stateId)
    {
        return $query->whereHas('city', function ($q) use ($stateId) {
            $q->where('state_id', $stateId);
        });
    }

    // Scope para filtrar por rango de precio
    public function scopePriceBetween($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }
}
