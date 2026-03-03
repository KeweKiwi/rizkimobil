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
    Schema::create('locations', function (Blueprint $table) {
        $table->id();

        $table->string('name');                 // Nama showroom/cabang
        $table->string('address')->nullable();  // Alamat lengkap
        $table->string('city')->nullable();
        $table->string('province')->nullable();
        $table->string('postal_code', 10)->nullable();

        $table->string('google_maps_url')->nullable();
        $table->string('phone', 30)->nullable();
        $table->string('whatsapp', 30)->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();

        $table->index(['city', 'province']);
        $table->index('is_active');
    });
}

};
