<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_bakus';

    protected $fillable = [
        'nama_bahan',
        'kategori',
        'stok',
        'satuan',
        'rata_rata_harian',
        'stok_minimum',
        'kapasitas_maksimal',
        'lead_time_hari',
        'harga_satuan',
        'keterangan',
    ];

    protected $casts = [
        'stok' => 'float',
        'rata_rata_harian' => 'float',
        'stok_minimum' => 'float',
        'kapasitas_maksimal' => 'float',
        'lead_time_hari' => 'integer',
        'harga_satuan' => 'integer',
    ];
}
