<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'models';

    public $timestamps = false;

    protected $fillable = ['name', 'maker_id'];

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    public function cars(): HasMany
    {
        // La columna en la tabla cars es model_id, no la convención car_model_id
        return $this->hasMany(Car::class, 'model_id');
    }
}
