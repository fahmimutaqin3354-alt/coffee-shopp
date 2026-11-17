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
        Schema::table('pesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('pesanans', 'nama_pembeli')) {
                $table->string('nama_pembeli')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'nomor_meja')) {
                $table->string('nomor_meja')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'menu_id')) {
                $table->unsignedBigInteger('menu_id')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'total_harga')) {
                $table->integer('total_harga')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'uang_diterima')) {
                $table->integer('uang_diterima')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'kembalian')) {
                $table->integer('kembalian')->nullable();
            }
            if (!Schema::hasColumn('pesanans', 'kasir_nama')) {
                $table->string('kasir_nama')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('pesanans', 'uang_diterima')) {
                $columnsToDrop[] = 'uang_diterima';
            }
            if (Schema::hasColumn('pesanans', 'kembalian')) {
                $columnsToDrop[] = 'kembalian';
            }
            if (Schema::hasColumn('pesanans', 'kasir_nama')) {
                $columnsToDrop[] = 'kasir_nama';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
