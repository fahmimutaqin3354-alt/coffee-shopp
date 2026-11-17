# NOIR COFFEE — Sistem Pakar Deteksi & Penanganan Mood Pelanggan (Certainty Factor)

Modul sistem pakar berbasis **Certainty Factor (CF)** yang dirancang khusus untuk **Karyawan / Kasir / Barista** NOIR COFFEE saat berhadapan langsung dengan pelanggan.

---

## ⚡ Fitur Utama

1. **Ultra Fast Input (< 10 Detik)**:
   - Berbasis *Quick Tag Checklist*: Cukup 3–5 klik tanda/gejala yang terlihat pada ekspresi wajah, bahasa tubuh, suara, atau cara memesan.
   - Perhitungan CF berlangsung secara **real-time** tanpa jeda reload halaman.

2. **Output Analisis Terpadu**:
   - **Mood Dominan**: Badge visual dengan indikator persentase keyakinan (contoh: `95.4%`).
   - **Tingkat Keyakinan Majemuk (Certainty Factor)**:
     $$CF(H, E) = CF_{pakar} \times CF_{user}$$
     $$CF_{combine} = CF_{old} + CF_{new} \times (1 - CF_{old})$$
   - **Distribusi Keyakinan**: Bar komparasi untuk 4 kategori mood (*Marah/Frustrasi*, *Terburu-buru/Gelisah*, *Ragu-ragu/Bimbang*, *Puas/Ramah*).
   - **Panduan Aksi (Do's & Don'ts)**: Poin konkret apa yang wajib dilakukan dan dilarang dilakukan karyawan.
   - **Skrip Kalimat Kasir (Katakan Ini)**: Template respon santun dengan tombol *1-Click Copy*.
   - **Rekomendasi Menu Pelengkap**: Saran minuman kopi/pastry yang secara neurobiologis membantu meredakan atau menyempurnakan mood pelanggan.

3. **Pencatatan Riwayat Shift**:
   - Tombol simpan catatan interaksi per meja/pelanggan.
   - Modal drawer untuk meninjau log interaksi shift aktif dan menghapus catatan.

4. **Desain Eksklusif NOIR COFFEE**:
   - Tema *Dark & Gold* (`#0c0803`, `#120d04`, `#c89b3c`).
   - Terintegrasi langsung dengan Dashboard Kasir POS (`http://127.0.0.1:8000/kasir`).

---

## 🚀 Cara Menjalankan

1. Buka terminal di folder project:
   ```bash
   cd "d:\local noir coffee\mood-expert-system"
   ```

2. Jalankan server:
   ```bash
   npm start
   ```
   *(Atau `node server.js`)*

3. Akses aplikasi:
   - **URL Detektor Mood**: [http://127.0.0.1:5000](http://127.0.0.1:5000)
   - **Dari Kasir POS**: Buka [http://127.0.0.1:8000/kasir](http://127.0.0.1:8000/kasir), lalu klik tombol navbar **"Deteksi Mood (CF)"**.

---

## 📚 Basis Pengetahuan & Bobot Pakar

### 4 Hipotesis Mood:
- **M01**: Marah / Frustrasi
- **M02**: Terburu-buru / Gelisah
- **M03**: Ragu-ragu / Bimbang
- **M04**: Puas / Ramah

### 14 Gejala Terdaftar:
- `G01`: Nada bicara tinggi, tajam, atau ketus ($CF_{pakar} = 0.85$ ke M01, $0.40$ ke M02)
- `G02`: Mengeluhkan antrean atau waktu tunggu ($CF_{pakar} = 0.80$ ke M01, $0.75$ ke M02)
- `G03`: Sering melihat jam tangan atau layar HP ($CF_{pakar} = 0.85$ ke M02)
- `G04`: Mengetuk-ngetuk jari / meja kasir ($CF_{pakar} = 0.80$ ke M02, $0.50$ ke M01)
- `G05`: Menghela nafas panjang / mendesah berat ($CF_{pakar} = 0.70$ ke M01, $0.60$ ke M02)
- `G06`: Postur tubuh tegang / melipat tangan ($CF_{pakar} = 0.75$ ke M01)
- `G07`: Menatap daftar menu sangat lama > 2 menit ($CF_{pakar} = 0.85$ ke M03)
- `G08`: Bertanya 'Menu yang enak apa ya?' ($CF_{pakar} = 0.80$ ke M03)
- `G09`: Mengubah-ubah pilihan pesanan berkali-kali ($CF_{pakar} = 0.75$ ke M03)
- `G10`: Menanyakan detail komposisi susu berulang kali ($CF_{pakar} = 0.70$ ke M03)
- `G11`: Tersenyum hangat dan menyapa kasir duluan ($CF_{pakar} = 0.90$ ke M04)
- `G12`: Nada bicara santai, ramah, dan antusias ($CF_{pakar} = 0.85$ ke M04)
- `G13`: Kontak mata bersahabat dan mengapresiasi ($CF_{pakar} = 0.75$ ke M04)
- `G14`: Meminta pesanan dipercepat / langsung siap ($CF_{pakar} = 0.90$ ke M02)
