<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbr_cases', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kasus', 20)->unique();
            $table->string('judul_masalah');
            $table->string('kategori_masalah');           // Mesin Espresso, Grinder, Bahan Baku, Peralatan, Operasional
            $table->json('gejala');                        // Array of gejala strings
            $table->json('kondisi');                       // Array of kondisi strings
            $table->text('solusi');                        // Solusi utama
            $table->json('langkah_penanganan')->nullable();// Step by step solution
            $table->decimal('bobot', 3, 2)->default(1.00);// Weight for similarity calc
            $table->boolean('is_verified')->default(false);// Sudah diverifikasi berhasil?
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbr_cases');
    }
};
