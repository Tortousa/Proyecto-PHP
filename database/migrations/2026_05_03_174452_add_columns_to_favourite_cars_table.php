<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta migración añade columnas especiales a la tabla pivote favourite_cars.
// Una tabla pivote normal solo tiene las claves foráneas (car_id, user_id).
// Al añadir columnas propias, podemos guardar información adicional sobre
// la relación entre un usuario y un coche favorito, no solo que existe.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favourite_cars', function (Blueprint $table) {
            // Nota personal del usuario sobre este coche favorito (ej: "me gusta el color")
            $table->string('notes')->nullable()->after('car_id');

            // Fecha en que se añadió a favoritos — para poder ordenar por "más reciente"
            $table->timestamp('added_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('favourite_cars', function (Blueprint $table) {
            $table->dropColumn(['notes', 'added_at']);
        });
    }
};
