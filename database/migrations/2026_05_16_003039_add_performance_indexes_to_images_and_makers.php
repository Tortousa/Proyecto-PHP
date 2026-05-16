<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $existingIndexes = fn(string $table) => collect(DB::select("SHOW INDEX FROM `{$table}`"))
            ->pluck('Key_name')->toArray();

        // Composite index para primaryImage() → oldestOfMany('position')
        if (!in_array('car_images_car_id_position_index', $existingIndexes('car_images'))) {
            Schema::table('car_images', function (Blueprint $table) {
                $table->index(['car_id', 'position'], 'car_images_car_id_position_index');
            });
        }

        // Índice en makers.name para el LIKE search
        if (!in_array('makers_name_index', $existingIndexes('makers'))) {
            Schema::table('makers', function (Blueprint $table) {
                $table->index('name', 'makers_name_index');
            });
        }

        // Índice en models.name para el LIKE search
        if (!in_array('models_name_index', $existingIndexes('models'))) {
            Schema::table('models', function (Blueprint $table) {
                $table->index('name', 'models_name_index');
            });
        }
    }

    public function down(): void
    {
        Schema::table('car_images', function (Blueprint $table) {
            $table->dropIndex('car_images_car_id_position_index');
        });

        Schema::table('makers', function (Blueprint $table) {
            $table->dropIndex('makers_name_index');
        });

        Schema::table('models', function (Blueprint $table) {
            $table->dropIndex('models_name_index');
        });
    }
};
