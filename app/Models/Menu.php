<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_kopi',
        'harga',
        'deskripsi',
        'gambar',
        'kategori',
        'jenis_menu',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rules()
    {
        return $this->hasMany(CoffeeRule::class, 'target_menu_id');
    }
}

