<?php

namespace Database\Seeders;

use App\Models\CbrCase;
use Illuminate\Database\Seeder;

class CbrCaseSeeder extends Seeder
{
    public function run(): void
    {
        $cases = [
            [
                'kode_kasus' => 'CBR001',
                'judul_masalah' => 'Kopi terlalu pahit',
                'kategori_masalah' => 'Mesin Espresso',
                'gejala' => ['Rasa kopi sangat pahit', 'Warna crema terlalu gelap', 'After taste tidak enak'],
                'kondisi' => ['Durasi ekstraksi terlalu lama', 'Grind size terlalu halus', 'Suhu air terlalu tinggi'],
                'solusi' => 'Periksa dan kurangi durasi ekstraksi. Sesuaikan grind size menjadi lebih kasar. Pastikan suhu air mesin antara 90-96°C.',
                'langkah_penanganan' => [
                    'Cek timer ekstraksi — idealnya 25-30 detik untuk double shot',
                    'Putar grinder ke arah lebih kasar 1-2 klik',
                    'Periksa pengaturan suhu mesin espresso',
                    'Buat test shot dan evaluasi rasa',
                    'Jika masih pahit, periksa kebersihan group head'
                ],
                'bobot' => 1.00,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR002',
                'judul_masalah' => 'Kopi terlalu encer',
                'kategori_masalah' => 'Mesin Espresso',
                'gejala' => ['Espresso terlihat encer', 'Crema tipis atau tidak ada', 'Rasa kopi lemah'],
                'kondisi' => ['Dosis bubuk kopi kurang', 'Grind size terlalu kasar', 'Tamping tidak rata'],
                'solusi' => 'Periksa dosis bubuk kopi (idealnya 18-20 gram untuk double shot). Sesuaikan grind size lebih halus. Pastikan tamping merata dengan tekanan konsisten.',
                'langkah_penanganan' => [
                    'Timbang dosis kopi — gunakan 18-20 gram untuk double shot',
                    'Putar grinder ke arah lebih halus 1-2 klik',
                    'Latih tamping dengan tekanan 15kg yang konsisten',
                    'Buat test shot dan ukur volume output (36-40ml)',
                    'Pastikan basket portafilter tidak rusak atau berlubang'
                ],
                'bobot' => 1.00,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR003',
                'judul_masalah' => 'Mesin tidak mengeluarkan air',
                'kategori_masalah' => 'Mesin Espresso',
                'gejala' => ['Air tidak keluar dari group head', 'Mesin menyala tapi tidak ada aliran', 'Suara pompa abnormal'],
                'kondisi' => ['Saluran air tersumbat', 'Pompa mesin bermasalah', 'Tangki air kosong'],
                'solusi' => 'Periksa saluran air apakah tersumbat oleh kerak. Pastikan tangki air terisi penuh. Jika pompa bersuara abnormal, hubungi teknisi.',
                'langkah_penanganan' => [
                    'Pastikan tangki air terisi penuh',
                    'Cek apakah ada tanda kerak pada saluran',
                    'Lakukan backflush dengan cairan descaling',
                    'Periksa filter air apakah tersumbat',
                    'Jika masalah berlanjut, hubungi teknisi mesin'
                ],
                'bobot' => 1.00,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR004',
                'judul_masalah' => 'Grinder macet / tidak berputar',
                'kategori_masalah' => 'Grinder',
                'gejala' => ['Grinder tidak berputar', 'Suara mesin berat atau macet', 'Bubuk kopi tidak keluar'],
                'kondisi' => ['Biji kopi tersangkut', 'Burr grinder kotor', 'Motor grinder overheat'],
                'solusi' => 'Matikan grinder. Bersihkan hopper dan burr dari sisa biji kopi yang tersangkut. Jika motor overheat, biarkan dingin 15-20 menit.',
                'langkah_penanganan' => [
                    'Matikan grinder dan cabut daya listrik',
                    'Buka hopper, keluarkan sisa biji kopi',
                    'Bersihkan burr dengan kuas khusus grinder',
                    'Periksa apakah ada benda asing (batu kecil) di antara burr',
                    'Pasang kembali dan test dengan sedikit biji kopi'
                ],
                'bobot' => 1.00,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR005',
                'judul_masalah' => 'Steam wand tidak mengeluarkan uap',
                'kategori_masalah' => 'Mesin Espresso',
                'gejala' => ['Uap tidak keluar dari steam wand', 'Steam lemah atau terputus-putus', 'Susu tidak bisa di-froth'],
                'kondisi' => ['Lubang steam wand tersumbat sisa susu', 'Boiler belum panas', 'Tekanan mesin rendah'],
                'solusi' => 'Bersihkan lubang ujung steam wand dengan jarum pin khusus. Pastikan boiler sudah mencapai suhu optimal. Periksa indikator tekanan mesin.',
                'langkah_penanganan' => [
                    'Rendam ujung steam wand dalam air panas 5 menit',
                    'Bersihkan lubang dengan jarum pin cleaning tool',
                    'Purge steam wand (buang uap kosong) selama 3 detik',
                    'Pastikan indikator tekanan mesin pada zona hijau',
                    'Test steaming dengan sedikit air di pitcher'
                ],
                'bobot' => 1.00,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR006',
                'judul_masalah' => 'Susu terlalu panas saat steaming',
                'kategori_masalah' => 'Operasional',
                'gejala' => ['Susu terasa gosong', 'Susu berbusa terlalu besar', 'Latte art tidak terbentuk'],
                'kondisi' => ['Suhu steaming melebihi 70°C', 'Pitcher terlalu lama di steam', 'Teknik steaming salah'],
                'solusi' => 'Jaga suhu steaming maksimal 65-70°C (saat pitcher terasa panas di tangan, segera stop). Gunakan termometer milk pitcher.',
                'langkah_penanganan' => [
                    'Gunakan termometer clip di milk pitcher',
                    'Mulai stretching susu saat masih dingin (fase udara)',
                    'Hentikan aerasi saat suhu 37-40°C',
                    'Stop steaming saat suhu mencapai 65°C',
                    'Ketuk pitcher dan swirl untuk menghilangkan bubble besar'
                ],
                'bobot' => 0.90,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR007',
                'judul_masalah' => 'Stok biji kopi habis mendadak',
                'kategori_masalah' => 'Bahan Baku',
                'gejala' => ['Stok biji kopi di hopper habis', 'Tidak ada biji kopi cadangan di gudang', 'Beberapa menu tidak bisa disajikan'],
                'kondisi' => ['Pencatatan stok tidak akurat', 'Supplier terlambat kirim', 'Peningkatan penjualan tidak terprediksi'],
                'solusi' => 'Hubungi supplier untuk pengiriman darurat. Sementara, tawarkan menu non-coffee. Perbaiki sistem pencatatan stok agar minimum order lebih akurat.',
                'langkah_penanganan' => [
                    'Hubungi supplier utama untuk pengiriman express',
                    'Jika supplier utama tidak bisa, kontak supplier cadangan',
                    'Informasikan ke kasir menu coffee yang temporarily unavailable',
                    'Arahkan pelanggan ke menu non-coffee atau tea',
                    'Setelah stok kembali, update kartu stok dan pasang reorder alert'
                ],
                'bobot' => 0.90,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR008',
                'judul_masalah' => 'Kulkas / chiller tidak dingin',
                'kategori_masalah' => 'Peralatan',
                'gejala' => ['Suhu kulkas naik di atas 8°C', 'Susu dan bahan segar berisiko basi', 'Kompresor kulkas bunyi keras'],
                'kondisi' => ['Pintu kulkas sering terbuka', 'Kompresor bermasalah', 'Freon habis atau bocor'],
                'solusi' => 'Periksa apakah pintu tertutup rapat. Bersihkan kondensor di bagian belakang. Jika kompresor bermasalah, hubungi teknisi pendingin.',
                'langkah_penanganan' => [
                    'Cek karet seal pintu kulkas, pastikan masih elastis',
                    'Pindahkan bahan segar ke cooler box sementara',
                    'Bersihkan debu pada kondensor belakang kulkas',
                    'Periksa pengaturan thermostat (ideal 2-4°C)',
                    'Hubungi teknisi jika masalah pada kompresor/freon'
                ],
                'bobot' => 0.90,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR009',
                'judul_masalah' => 'Rasa kopi berubah dari biasanya',
                'kategori_masalah' => 'Bahan Baku',
                'gejala' => ['Rasa kopi berbeda dari standar', 'Pelanggan komplain rasa berubah', 'Aroma kopi kurang'],
                'kondisi' => ['Biji kopi sudah melewati masa roast date', 'Penyimpanan biji kopi tidak kedap udara', 'Batch biji kopi baru berbeda profil'],
                'solusi' => 'Periksa tanggal roast biji kopi (idealnya 7-21 hari setelah roast). Pastikan penyimpanan dalam wadah kedap udara. Lakukan cupping untuk membandingkan.',
                'langkah_penanganan' => [
                    'Cek label roast date pada kemasan biji kopi',
                    'Pindahkan biji kopi ke canister kedap udara dengan valve',
                    'Lakukan cupping test membandingkan batch lama vs baru',
                    'Sesuaikan grind size jika batch baru berbeda density',
                    'Catat profil rasa batch baru untuk referensi barista'
                ],
                'bobot' => 0.95,
                'is_verified' => true,
            ],
            [
                'kode_kasus' => 'CBR010',
                'judul_masalah' => 'Mesin kasir / POS error',
                'kategori_masalah' => 'Operasional',
                'gejala' => ['Aplikasi kasir tidak bisa dibuka', 'Transaksi gagal tersimpan', 'Printer struk error'],
                'kondisi' => ['Koneksi internet terputus', 'Sistem crash atau hang', 'Printer kehabisan kertas thermal'],
                'solusi' => 'Restart aplikasi dan perangkat. Periksa koneksi internet. Untuk printer, ganti kertas thermal atau restart printer.',
                'langkah_penanganan' => [
                    'Tutup paksa aplikasi kasir dan buka ulang',
                    'Jika masih error, restart komputer / tablet kasir',
                    'Periksa koneksi WiFi atau kabel LAN',
                    'Untuk printer: ganti gulungan kertas thermal baru',
                    'Catat transaksi manual jika sistem belum pulih, input setelah normal'
                ],
                'bobot' => 0.85,
                'is_verified' => true,
            ],
        ];

        foreach ($cases as $caseData) {
            CbrCase::updateOrCreate(
                ['kode_kasus' => $caseData['kode_kasus']],
                $caseData
            );
        }
    }
}
