<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CarImages extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['image_path', 'position'];

    // Accessor: devuelve la URL pública de la imagen.
    // Si image_path empieza por "http" es una URL externa (LoremFlickr, etc.) y se usa tal cual.
    // Si no, es una ruta local en storage y se genera la URL con Storage::url().
    public function getUrlAttribute(): string
    {
        return str_starts_with($this->image_path, 'http')
            ? $this->image_path
            : Storage::url($this->image_path);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
