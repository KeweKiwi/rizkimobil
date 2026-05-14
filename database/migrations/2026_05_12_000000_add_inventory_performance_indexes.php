<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->index(['sold', 'created_at'], 'cars_sold_created_at_idx');
            $table->index(['sold', 'price'], 'cars_sold_price_idx');
            $table->index(['sold', 'year'], 'cars_sold_year_idx');
            $table->index(['sold', 'mileage_km'], 'cars_sold_mileage_idx');
            $table->index(['sold', 'make', 'model'], 'cars_sold_make_model_idx');
            $table->index(['sold', 'body_type'], 'cars_sold_body_type_idx');
            $table->index(['sold', 'fuel_type'], 'cars_sold_fuel_type_idx');
            $table->index(['sold', 'transmission'], 'cars_sold_transmission_idx');
        });

        Schema::table('car_images', function (Blueprint $table) {
            $table->index(['car_id', 'is_primary'], 'car_images_car_primary_idx');
            $table->index(['car_id', 'sort_order'], 'car_images_car_sort_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_images', function (Blueprint $table) {
            $table->dropIndex('car_images_car_sort_idx');
            $table->dropIndex('car_images_car_primary_idx');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('cars_sold_transmission_idx');
            $table->dropIndex('cars_sold_fuel_type_idx');
            $table->dropIndex('cars_sold_body_type_idx');
            $table->dropIndex('cars_sold_make_model_idx');
            $table->dropIndex('cars_sold_mileage_idx');
            $table->dropIndex('cars_sold_year_idx');
            $table->dropIndex('cars_sold_price_idx');
            $table->dropIndex('cars_sold_created_at_idx');
        });
    }
};
