<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class State extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    // La tabla cars no tiene state_id: se relaciona con el estado a través de la ciudad
    // (cars.city_id → cities.id → cities.state_id).
    public function cars(): HasManyThrough
    {
        return $this->hasManyThrough(Car::class, City::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
