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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            // Optional tapi enak untuk display listing
            $table->string('title')->nullable();          // contoh: "Toyota Rush GR Sport"
            $table->string('make');                       // Toyota
            $table->string('model');                      // Rush
            $table->string('variant')->nullable();        // GR Sport (optional)

            // Detail spesifikasi (sesuai UI kamu)
            $table->unsignedSmallInteger('year');         // Tahun Perakitan (2023)
            $table->unsignedInteger('mileage_km');        // Kilometer (9861)
            $table->enum('transmission', ['manual', 'automatic'])->nullable();
            $table->enum('fuel_type', ['bensin', 'diesel', 'electric', 'hybrid'])->nullable();
            $table->string('color')->nullable();          // KUNING
            $table->unsignedTinyInteger('seats')->nullable(); // 5

            $table->enum('body_type', [
                'suv', 'sedan', 'hatchback', 'mpv', 'pickup', 'van', 'coupe', 'convertible', 'wagon'
            ])->nullable();

            $table->enum('plate_parity', ['ganjil', 'genap'])->nullable(); // Plat Nomor
            $table->date('stnk_valid_until')->nullable();                  // Masa Berlaku STNK (Feb 2026)

            // Bisnis
            $table->unsignedBigInteger('price')->nullable(); // lebih enak integer rupiah (285000000)
            $table->text('description')->nullable();

            // Optional identitas mobil (kalau kamu pakai)
            $table->string('vin')->nullable()->unique();

            // Features: boleh tetap JSON dulu (cepat), nanti bisa dipisah tabel jika mau
            $table->json('features')->nullable();

            // Status
            $table->boolean('featured')->default(false);
            $table->boolean('sold')->default(false);

            $table->timestamps();

            // Indexes (buat pencarian/filter)
            $table->index(['make', 'model']);
            $table->index('year');
            $table->index('price');
            $table->index(['featured', 'sold']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
