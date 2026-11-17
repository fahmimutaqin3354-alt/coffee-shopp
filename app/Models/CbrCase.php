<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CbrCase extends Model
{
    protected $table = 'cbr_cases';

    protected $fillable = [
        'kode_kasus',
        'judul_masalah',
        'kategori_masalah',
        'gejala',
        'kondisi',
        'solusi',
        'langkah_penanganan',
        'bobot',
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'gejala' => 'array',
        'kondisi' => 'array',
        'langkah_penanganan' => 'array',
        'bobot' => 'decimal:2',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];
}
