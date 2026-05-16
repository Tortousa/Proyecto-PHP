<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasIndex('car_images', 'car_images_car_id_position_index')) {
            Schema::table('car_images', function (Blueprint $table) {
                $table->index(['car_id', 'position'], 'car_images_car_id_position_index');
            });
        }

        if (!Schema::hasIndex('makers', 'makers_name_index')) {
            Schema::table('makers', function (Blueprint $table) {
                $table->index('name', 'makers_name_index');
            });
        }

        if (!Schema::hasIndex('models', 'models_name_index')) {
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
