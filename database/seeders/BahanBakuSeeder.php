<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use Illuminate\Database\Seeder;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic specialty coffee shop operational data.
     * Standar kafe kapasitas 70-120 cup/hari di Indonesia.
     */
    public function run(): void
    {
        $items = [
            [
                'nama_bahan' => 'Biji Kopi Arabika House Blend (Gayo & Kintamani)',
                'kategori' => 'Biji Kopi',
                'stok' => 3.5, // Stok tersisa kritis untuk kafe yang butuh 2 kg/hari
                'satuan' => 'kg',
                'rata_rata_harian' => 2.2, // ~110-120 shot espresso per hari (18g/shot)
                'stok_minimum' => 6.0,
                'kapasitas_maksimal' => 25.0, // Kapasitas penyimpanan ideal biji kopi agar tetap fresh
                'lead_time_hari' => 3, // Waktu kirim roastery lokal 3 hari
                'harga_satuan' => 165000, // Rp 165.000 / kg
                'keterangan' => 'Medium roast untuk espresso, americano, dan latte signature',
            ],
            [
                'nama_bahan' => 'Biji Kopi Robusta Java Dampit Grade 1',
                'kategori' => 'Biji Kopi',
                'stok' => 8.0,
                'satuan' => 'kg',
                'rata_rata_harian' => 1.8, // ~90-100 cup kopi susu gula aren/hari
                'stok_minimum' => 5.0,
                'kapasitas_maksimal' => 20.0,
                'lead_time_hari' => 2,
                'harga_satuan' => 95000, // Rp 95.000 / kg
                'keterangan' => 'Dark roast body tebal untuk racikan Kopi Gula Aren & Es Kopi Susu',
            ],
            [
                'nama_bahan' => 'Susu Fresh Milk Pasteurisasi (Diamond / Greenfields)',
                'kategori' => 'Dairy & Susu',
                'stok' => 9.0, // Mendekati habis
                'satuan' => 'liter',
                'rata_rata_harian' => 12.5, // 1 liter = ~6 cup latte/cappuccino (160ml/cup) -> butuh ~75 cup/hari
                'stok_minimum' => 15.0,
                'kapasitas_maksimal' => 45.0, // Kapasitas chiller kafe
                'lead_time_hari' => 1, // Supplier susu harian (1 hari tiba)
                'harga_satuan' => 21000, // Rp 21.000 / liter
                'keterangan' => 'Susu segar dingin pasteurisasi wajib suhu 2-4°C',
            ],
            [
                'nama_bahan' => 'Gula Aren Cair Organik (Nira Murni)',
                'kategori' => 'Pemanis & Sirup',
                'stok' => 4.5,
                'satuan' => 'liter',
                'rata_rata_harian' => 1.6, // 1 liter = 40 cup (25ml/cup)
                'stok_minimum' => 4.0,
                'kapasitas_maksimal' => 20.0,
                'lead_time_hari' => 2,
                'harga_satuan' => 38000, // Rp 38.000 / liter jerigen
                'keterangan' => 'Gula aren cair kental aroma karamel alami khas nusantara',
            ],
            [
                'nama_bahan' => 'Sirup Vanilla Premium (Monin / Toffin 700ml)',
                'kategori' => 'Pemanis & Sirup',
                'stok' => 1.0, // Sangat tipis, tinggal 1 botol
                'satuan' => 'botol',
                'rata_rata_harian' => 0.5, // 1 botol (700ml) = ~35 cup (20ml pump). Habis tiap 2 hari.
                'stok_minimum' => 2.0,
                'kapasitas_maksimal' => 8.0,
                'lead_time_hari' => 3,
                'harga_satuan' => 145000, // Rp 145.000 / botol
                'keterangan' => 'Sirup perasa vanilla untuk menu Vanilla Latte',
            ],
            [
                'nama_bahan' => 'Sirup Karamel Kental (Monin / Toffin 700ml)',
                'kategori' => 'Pemanis & Sirup',
                'stok' => 4.0,
                'satuan' => 'botol',
                'rata_rata_harian' => 0.4,
                'stok_minimum' => 2.0,
                'kapasitas_maksimal' => 8.0,
                'lead_time_hari' => 3,
                'harga_satuan' => 145000,
                'keterangan' => 'Drizzle & sirup karamel untuk Caramel Macchiato',
            ],
            [
                'nama_bahan' => 'Bubuk Pure Matcha Uji Jepang',
                'kategori' => 'Powder & Non-Coffee',
                'stok' => 0.8, // 800 gram
                'satuan' => 'kg',
                'rata_rata_harian' => 0.35, // 1 kg = 40-50 cup (20g/cup)
                'stok_minimum' => 1.0,
                'kapasitas_maksimal' => 5.0,
                'lead_time_hari' => 4, // Pengiriman kurir luar kota
                'harga_satuan' => 260000, // Rp 260.000 / kg
                'keterangan' => 'Ceremonial & cafe grade warna hijau cerah tanpa pemanis tambahan',
            ],
            [
                'nama_bahan' => 'Bubuk Taro Creamy Powder',
                'kategori' => 'Powder & Non-Coffee',
                'stok' => 2.5,
                'satuan' => 'kg',
                'rata_rata_harian' => 0.3,
                'stok_minimum' => 1.0,
                'kapasitas_maksimal' => 6.0,
                'lead_time_hari' => 3,
                'harga_satuan' => 85000, // Rp 85.000 / kg
                'keterangan' => 'Bubuk minuman taro manis gurih untuk menu Taro Milk',
            ],
            [
                'nama_bahan' => 'Bubuk Cokelat Dark Kakao Premium',
                'kategori' => 'Powder & Non-Coffee',
                'stok' => 3.2,
                'satuan' => 'kg',
                'rata_rata_harian' => 0.45,
                'stok_minimum' => 1.5,
                'kapasitas_maksimal' => 8.0,
                'lead_time_hari' => 3,
                'harga_satuan' => 115000, // Rp 115.000 / kg
                'keterangan' => 'Dutch process cocoa powder untuk Mocha dan Chocolate Latte',
            ],
            [
                'nama_bahan' => 'Cup Plastik Dingin 16oz PP + Lid Strawless',
                'kategori' => 'Packaging & Cup',
                'stok' => 140, // 140 pcs (hanya cukup 1-2 hari)
                'satuan' => 'pcs',
                'rata_rata_harian' => 90, // 90 minuman dingin / hari
                'stok_minimum' => 250,
                'kapasitas_maksimal' => 1000, // 1 dus isi 1000 pcs
                'lead_time_hari' => 2,
                'harga_satuan' => 750, // Rp 750 / pcs (gelas + tutup)
                'keterangan' => 'Gelas tebal inject/PP bening untuk semua es kopi & mocktail',
            ],
            [
                'nama_bahan' => 'Paper Cup Panas 8oz Double Wall + Lid',
                'kategori' => 'Packaging & Cup',
                'stok' => 380, // Masih aman
                'satuan' => 'pcs',
                'rata_rata_harian' => 25, // Minuman panas terjual ~25 cup/hari
                'stok_minimum' => 100,
                'kapasitas_maksimal' => 800,
                'lead_time_hari' => 2,
                'harga_satuan' => 650, // Rp 650 / pcs
                'keterangan' => 'Paper cup isolasi panas untuk hot americano & cappuccino',
            ],
            [
                'nama_bahan' => 'Kentang Frozen Straight Cut (Aviko / Lutosa)',
                'kategori' => 'Bahan Makanan',
                'stok' => 5.0, // 5 kg
                'satuan' => 'kg',
                'rata_rata_harian' => 3.0, // 1 porsi = 150 gram (20 porsi/hari = 3 kg)
                'stok_minimum' => 6.0,
                'kapasitas_maksimal' => 25.0, // Kapasitas freezer bahan
                'lead_time_hari' => 1,
                'harga_satuan' => 34000, // Rp 34.000 / kg pack
                'keterangan' => 'Kentang beku impor renyah untuk menu French Fries',
            ],
        ];

        // Kosongkan dan isi ulang dengan data realistis terkini
        BahanBaku::truncate();

        foreach ($items as $item) {
            BahanBaku::create($item);
        }
    }
}
