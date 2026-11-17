<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Mood Pelanggan — NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #c89b3c;
            --gold-light: #e5c378;
            --gold-hover: #b88628;
            --dark-base: #140f05;
            --dark-surface: #1b1407;
            --dark-card: #221a0c;
            --dark-border: rgba(200, 155, 60, 0.22);
            --cream: #f5eee3;
            --green: #22c55e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-base);
            color: #f8f3e7;
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .navbar-kasir {
            background: rgba(27, 20, 7, 0.98);
            border-bottom: 1px solid var(--dark-border);
            padding: 12px 24px;
        }

        .logo-img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--gold);
            padding: 2px;
            background: var(--dark-base);
        }

        .btn-pos-nav {
            background: #2a2012;
            color: #e5dec2;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-pos-nav:hover, .btn-pos-nav.active {
            background: var(--gold);
            color: #140f05;
            border-color: var(--gold);
        }

        /* Cards */
        .mood-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 24px;
        }

        /* Question cards */
        .question-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .question-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 12px;
        }

        .question-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--gold);
            color: var(--dark-base);
            font-weight: 800;
            font-size: 13px;
            margin-right: 10px;
        }

        /* Option buttons */
        .mood-option-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mood-option {
            background: #2a2012;
            border: 2px solid rgba(200, 155, 60, 0.2);
            border-radius: 12px;
            padding: 10px 18px;
            color: #e5dec2;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }

        .mood-option:hover {
            border-color: var(--gold);
            background: rgba(200, 155, 60, 0.1);
        }

        .mood-option.selected {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-hover) 100%);
            color: #140f05;
            border-color: var(--gold);
            box-shadow: 0 4px 15px rgba(200, 155, 60, 0.3);
        }

        .mood-option i {
            font-size: 18px;
        }

        /* Result Panel */
        .result-panel {
            display: none;
            animation: fadeSlideUp 0.5s ease;
        }

        .result-panel.show {
            display: block;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mood-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 18px;
        }

        .mood-badge i {
            font-size: 28px;
        }

        .cf-meter {
            height: 12px;
            border-radius: 20px;
            background: #2a2012;
            overflow: hidden;
            border: 1px solid var(--dark-border);
        }

        .cf-meter-fill {
            height: 100%;
            border-radius: 20px;
            transition: width 0.8s ease;
        }

        /* Guidance cards */
        .guide-do {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 14px;
            padding: 16px;
        }

        .guide-dont {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 14px;
            padding: 16px;
        }

        .guide-title {
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .guide-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .guide-list li {
            font-size: 13px;
            padding: 4px 0;
            line-height: 1.6;
        }

        .guide-list li i {
            margin-right: 6px;
        }

        /* Script card */
        .script-card {
            background: var(--dark-card);
            border: 1px solid var(--gold);
            border-radius: 14px;
            padding: 16px;
            position: relative;
        }

        .script-text {
            font-style: italic;
            font-size: 14px;
            line-height: 1.7;
            color: #e5dec2;
        }

        .btn-copy-script {
            background: rgba(200, 155, 60, 0.2);
            border: 1px solid var(--gold);
            color: var(--gold-light);
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-copy-script:hover {
            background: var(--gold);
            color: var(--dark-base);
        }

        /* Menu recommendation card */
        .menu-reco-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-reco-img {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--dark-border);
        }

        /* All moods breakdown */
        .mood-bar-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .mood-bar-label {
            font-size: 12px;
            font-weight: 600;
            min-width: 140px;
        }

        .mood-bar-track {
            flex: 1;
            height: 8px;
            background: #2a2012;
            border-radius: 10px;
            overflow: hidden;
        }

        .mood-bar-track-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.8s ease;
        }

        .mood-bar-pct {
            font-size: 12px;
            font-weight: 700;
            min-width: 50px;
            text-align: right;
            font-family: monospace;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mood-option {
                padding: 8px 14px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar-kasir d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo.jpg') }}" alt="Noir Coffee Logo" class="logo-img">
            <div>
                <span class="fw-bold fs-5 tracking-wide text-white">NOIR <span style="color:var(--gold);">COFFEE</span></span>
                <span class="text-muted ms-1 fs-6">| DETEKSI MOOD</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('kasir.index') }}" class="btn-pos-nav">
                <i class="bi bi-calculator"></i> Kasir POS
            </a>
            <a href="{{ route('kasir.pesanan') }}" class="btn-pos-nav">
                <i class="bi bi-clock-history"></i> Antrean Pesanan
            </a>
            <a href="{{ route('kasir.laporan') }}" class="btn-pos-nav">
                <i class="bi bi-bar-chart-line"></i> Rekap Shift
            </a>
            <a href="{{ route('kasir.mood') }}" class="btn-pos-nav active" style="background: var(--gold); color: #140f05; border-color: var(--gold);">
                <i class="bi bi-emoji-smile"></i> Deteksi Mood (CF)
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="btn-pos-nav" style="border-color: var(--gold); color: var(--gold);">
                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                </a>
            @endif
        </div>
    </nav>

    <div class="container" style="max-width: 1100px;">

        <!-- HEADER -->
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1">
                <i class="bi bi-emoji-smile-fill" style="color: var(--gold);"></i>
                Sistem Pakar Deteksi Mood Pelanggan
            </h3>
            <p class="text-muted small mb-0">
                Tanyakan 3 pertanyaan singkat ke pelanggan, lalu sistem akan menghitung mood dominan menggunakan <strong style="color: var(--gold-light);">metode Certainty Factor (CF)</strong> dan memberikan panduan respon terbaik.
            </p>
        </div>

        <div class="row g-4">

            <!-- LEFT: PERTANYAAN -->
            <div class="col-lg-5">
                <div class="mood-card">
                    <h5 class="fw-bold mb-3" style="color: var(--gold-light);">
                        <i class="bi bi-chat-dots-fill me-2"></i>Tanyakan ke Pelanggan
                    </h5>

                    <!-- P1: Perasaan hari ini -->
                    <div class="question-card">
                        <div class="question-title">
                            <span class="question-number">1</span>
                            Bagaimana perasaan Anda hari ini?
                        </div>
                        <div class="mood-option-group" data-question="perasaan">
                            <div class="mood-option" data-value="senang" onclick="selectOption(this)">
                                <i class="bi bi-emoji-laughing"></i> Senang / Ceria
                            </div>
                            <div class="mood-option" data-value="biasa" onclick="selectOption(this)">
                                <i class="bi bi-emoji-neutral"></i> Biasa saja
                            </div>
                            <div class="mood-option" data-value="lelah" onclick="selectOption(this)">
                                <i class="bi bi-emoji-expressionless"></i> Lelah / Capek
                            </div>
                            <div class="mood-option" data-value="kesal" onclick="selectOption(this)">
                                <i class="bi bi-emoji-frown"></i> Kesal / Jengkel
                            </div>
                            <div class="mood-option" data-value="buru" onclick="selectOption(this)">
                                <i class="bi bi-stopwatch"></i> Buru-buru
                            </div>
                            <div class="mood-option" data-value="bingung" onclick="selectOption(this)">
                                <i class="bi bi-question-circle"></i> Bingung
                            </div>
                        </div>
                    </div>

                    <!-- P2: Suasana hati saat ini -->
                    <div class="question-card">
                        <div class="question-title">
                            <span class="question-number">2</span>
                            Apa yang paling Anda butuhkan saat ini?
                        </div>
                        <div class="mood-option-group" data-question="kebutuhan">
                            <div class="mood-option" data-value="santai" onclick="selectOption(this)">
                                <i class="bi bi-cup-hot"></i> Santai & Nikmati
                            </div>
                            <div class="mood-option" data-value="cepat" onclick="selectOption(this)">
                                <i class="bi bi-lightning-charge"></i> Dilayani cepat
                            </div>
                            <div class="mood-option" data-value="rekomendasi" onclick="selectOption(this)">
                                <i class="bi bi-lightbulb"></i> Rekomendasi menu
                            </div>
                            <div class="mood-option" data-value="tenang" onclick="selectOption(this)">
                                <i class="bi bi-peace"></i> Ketenangan
                            </div>
                        </div>
                    </div>

                    <!-- P3: Tingkat energi -->
                    <div class="question-card">
                        <div class="question-title">
                            <span class="question-number">3</span>
                            Bagaimana tingkat energi Anda saat ini?
                        </div>
                        <div class="mood-option-group" data-question="energi">
                            <div class="mood-option" data-value="tinggi" onclick="selectOption(this)">
                                <i class="bi bi-battery-full" style="color:#22c55e;"></i> Tinggi / Semangat
                            </div>
                            <div class="mood-option" data-value="sedang" onclick="selectOption(this)">
                                <i class="bi bi-battery-half" style="color:#f59e0b;"></i> Sedang
                            </div>
                            <div class="mood-option" data-value="rendah" onclick="selectOption(this)">
                                <i class="bi bi-battery-low" style="color:#ef4444;"></i> Rendah / Lemas
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-3">
                        <button class="btn w-100 fw-bold py-2" style="background: var(--gold); color: var(--dark-base); border-radius: 12px; font-size: 15px;" onclick="hitungMood()" id="btnHitung" disabled>
                            <i class="bi bi-cpu me-1"></i> Analisis Mood (CF)
                        </button>
                        <button class="btn fw-bold py-2 px-3" style="background: #2a2012; color: #e5dec2; border: 1px solid var(--dark-border); border-radius: 12px;" onclick="resetForm()" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </div>

                    <div class="text-center mt-2">
                        <small class="text-muted" id="statusText">Pilih jawaban untuk ketiga pertanyaan di atas</small>
                    </div>
                </div>
            </div>

            <!-- RIGHT: HASIL ANALISIS -->
            <div class="col-lg-7">

                <!-- Empty State -->
                <div id="emptyState" class="mood-card text-center py-5">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: rgba(200, 155, 60, 0.12); border: 1px solid var(--dark-border); display: inline-flex; align-items: center; justify-content: center; font-size: 36px; color: var(--gold-light); margin-bottom: 16px;">
                        <i class="bi bi-person-bounding-box"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Belum Ada Analisis</h5>
                    <p class="text-muted small mb-0" style="max-width: 360px; margin: 0 auto;">
                        Tanyakan 3 pertanyaan singkat di sebelah kiri kepada pelanggan, lalu tekan tombol <strong style="color: var(--gold-light);">Analisis Mood</strong> untuk mendapatkan panduan respon.
                    </p>
                </div>

                <!-- Result Panel -->
                <div id="resultPanel" class="result-panel">

                    <!-- Dominant Mood Badge -->
                    <div class="mood-card mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge text-uppercase fw-bold" style="background: rgba(200, 155, 60, 0.2); color: var(--gold-light); font-size: 11px; letter-spacing: 1px;">
                                    <i class="bi bi-cpu me-1"></i> Hasil Inferensi CF
                                </span>
                            </div>
                            <span id="resultMoodCode" class="badge fw-bold" style="font-size: 11px;">M01</span>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div id="resultMoodBadge" class="mood-badge">
                                <i id="resultMoodIcon" class="bi bi-emoji-smile-fill"></i>
                                <span id="resultMoodName">Puas / Ramah</span>
                            </div>
                            <div class="text-end">
                                <div id="resultMoodPct" class="fw-bold" style="font-size: 28px; font-family: monospace;">95.0%</div>
                                <small class="text-muted">Tingkat Keyakinan</small>
                            </div>
                        </div>

                        <p id="resultMoodSubtitle" class="text-muted small mb-3">Pelanggan dalam suasana hati yang baik</p>

                        <!-- CF Meter -->
                        <div class="cf-meter mb-3">
                            <div id="resultCfMeter" class="cf-meter-fill" style="width: 0%; background: var(--gold);"></div>
                        </div>

                        <!-- All Moods Breakdown -->
                        <div class="p-3 rounded-3" style="background: rgba(10, 7, 2, 0.5); border: 1px solid var(--dark-border);">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="fw-bold text-muted text-uppercase" style="letter-spacing: 1px;">Distribusi Keyakinan</small>
                                <small class="text-muted" style="font-family: monospace;">CF Combine</small>
                            </div>
                            <div id="allMoodsBars"></div>
                        </div>
                    </div>

                    <!-- DO's & DON'TS -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="guide-do h-100">
                                <div class="guide-title" style="color: #22c55e;">
                                    <i class="bi bi-check-circle-fill me-1"></i> WAJIB DILAKUKAN
                                </div>
                                <ul class="guide-list" id="resultDos"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="guide-dont h-100">
                                <div class="guide-title" style="color: #ef4444;">
                                    <i class="bi bi-x-octagon-fill me-1"></i> DILARANG DILAKUKAN
                                </div>
                                <ul class="guide-list" id="resultDonts"></ul>
                            </div>
                        </div>
                    </div>

                    <!-- Script Kalimat -->
                    <div class="script-card mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold small" style="color: var(--gold-light);">
                                <i class="bi bi-chat-quote-fill me-1"></i> Contoh Kalimat Kasir
                            </span>
                            <button class="btn-copy-script" onclick="copyScript()">
                                <i class="bi bi-clipboard me-1"></i> Salin
                            </button>
                        </div>
                        <div class="script-text" id="resultScript">
                            "Terima kasih telah berkunjung ke NOIR COFFEE!"
                        </div>
                    </div>

                    <!-- Menu Recommendation -->
                    <div class="mood-card">
                        <h6 class="fw-bold mb-3" style="color: var(--gold-light);">
                            <i class="bi bi-cup-hot-fill me-2"></i>Rekomendasi Menu Pelengkap Mood
                        </h6>
                        <div id="resultMenuCards" class="d-flex flex-column gap-2"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ============================================================
        //  NOIR COFFEE — Sistem Pakar Deteksi Mood (Certainty Factor)
        //  Terintegrasi langsung di halaman Kasir Laravel
        // ============================================================

        // Jawaban yang dipilih user
        const answers = {
            perasaan: null,
            kebutuhan: null,
            energi: null
        };

        // Menu data dari Laravel (untuk rekomendasi)
        const menuList = @json($menus);

        // ==========================================
        //  KNOWLEDGE BASE — Bobot CF Pakar
        // ==========================================
        //
        //  Setiap jawaban pertanyaan memberikan evidence
        //  ke satu atau beberapa mood dengan bobot CF pakar.
        //
        //  Mood:
        //   M01 = Marah / Frustrasi
        //   M02 = Terburu-buru / Gelisah
        //   M03 = Ragu-ragu / Bimbang
        //   M04 = Puas / Ramah
        //
        //  Formula:
        //   CF(H,E) = CF_pakar × CF_user (CF_user = 1.0 karena pelanggan menjawab sendiri)
        //   CF_combine = CF_old + CF_new × (1 − CF_old)
        // ==========================================

        const knowledgeBase = {
            // Pertanyaan 1: Perasaan
            perasaan: {
                senang:  { M04: 0.90, M03: 0.0,  M02: 0.0,  M01: 0.0  },
                biasa:   { M04: 0.40, M03: 0.30, M02: 0.20, M01: 0.0  },
                lelah:   { M03: 0.50, M01: 0.40, M04: 0.10, M02: 0.20 },
                kesal:   { M01: 0.90, M02: 0.30, M03: 0.0,  M04: 0.0  },
                buru:    { M02: 0.90, M01: 0.20, M03: 0.0,  M04: 0.0  },
                bingung: { M03: 0.85, M02: 0.20, M01: 0.0,  M04: 0.0  }
            },
            // Pertanyaan 2: Kebutuhan
            kebutuhan: {
                santai:      { M04: 0.80, M03: 0.20, M01: 0.0,  M02: 0.0  },
                cepat:       { M02: 0.85, M01: 0.30, M03: 0.0,  M04: 0.0  },
                rekomendasi: { M03: 0.80, M04: 0.30, M01: 0.0,  M02: 0.0  },
                tenang:      { M01: 0.60, M03: 0.40, M04: 0.20, M02: 0.0  }
            },
            // Pertanyaan 3: Energi
            energi: {
                tinggi: { M04: 0.70, M02: 0.40, M01: 0.20, M03: 0.0  },
                sedang: { M04: 0.40, M03: 0.40, M02: 0.30, M01: 0.20 },
                rendah: { M01: 0.50, M03: 0.50, M02: 0.20, M04: 0.10 }
            }
        };

        // ==========================================
        //  MOOD DEFINITIONS — Info, Panduan, Skrip
        // ==========================================

        const moodDefs = {
            M01: {
                code: 'M01',
                name: 'Marah / Frustrasi',
                subtitle: 'Pelanggan sedang kesal, kecewa, atau jengkel',
                icon: 'bi-emoji-angry-fill',
                color: '#ef4444',
                bgSoft: 'rgba(239, 68, 68, 0.15)',
                dos: [
                    'Dengarkan keluhan dengan sabar tanpa memotong pembicaraan',
                    'Sampaikan permohonan maaf dengan tulus dan nada rendah',
                    'Segera prioritaskan pesanan atau tawarkan complimentary snack',
                    'Tunjukkan bahasa tubuh terbuka dan fokus membantu'
                ],
                donts: [
                    'Jangan mendebat atau menyalahkan pelanggan',
                    'Jangan memasang ekspresi meremehkan masalah',
                    'Jangan berkata "Bukan salah saya" atau "Memang aturannya"',
                    'Jangan membuat pelanggan menunggu tanpa kepastian'
                ],
                scripts: [
                    '"Mohon maaf atas ketidaknyamanan yang dialami ya Kak. Saya sangat memahami perasaan Kakak. Izinkan saya segera memprioritaskan pesanan Kakak sekarang."',
                    '"Terima kasih atas kesabarannya Kak. Sebagai permohonan maaf, silakan nikmati pastry spesial dari kami ya."'
                ],
                menuKeywords: ['Caramel Macchiato', 'Chocolate Latte', 'Brownies Ice Cream', 'Taro Milk'],
                menuReason: 'Minuman manis & gurih terbukti membantu meredakan stres dan memberikan kenyamanan.'
            },
            M02: {
                code: 'M02',
                name: 'Terburu-buru / Gelisah',
                subtitle: 'Pelanggan dikejar waktu dan butuh layanan cepat',
                icon: 'bi-stopwatch-fill',
                color: '#f59e0b',
                bgSoft: 'rgba(245, 158, 11, 0.15)',
                dos: [
                    'Langsung tawarkan menu ready-to-serve yang cepat disajikan',
                    'Siapkan cup take-away dan kantong sebelum diminta',
                    'Proses transaksi dengan cepat (< 30 detik)',
                    'Beri kepastian waktu: "Siap dalam 2 menit ya Kak!"'
                ],
                donts: [
                    'Jangan menawarkan menu yang perlu waktu lama',
                    'Jangan berbasa-basi atau memperpanjang obrolan',
                    'Jangan bertanya terlalu banyak hal tambahan',
                    'Jangan membuat pelanggan mengulang pesanan'
                ],
                scripts: [
                    '"Baik Kak, saya bantu proseskan secepat mungkin ya! Americano Iced kami bisa langsung siap dalam 2 menit, mau sekalian take away?"',
                    '"Pesanan Kakak saya prioritaskan ya, langsung siap! Untuk pembayarannya bisa tap QRIS di sini biar lebih cepat."'
                ],
                menuKeywords: ['Americano', 'Espresso', 'Lemon Tea', 'Kopi Gula Aren'],
                menuReason: 'Menu yang cepat disajikan dan praktis untuk dibawa pergi (take away).'
            },
            M03: {
                code: 'M03',
                name: 'Ragu-ragu / Bimbang',
                subtitle: 'Pelanggan butuh bantuan memilih dan butuh rekomendasi',
                icon: 'bi-question-circle-fill',
                color: '#06b6d4',
                bgSoft: 'rgba(6, 182, 212, 0.15)',
                dos: [
                    'Berikan 2-3 rekomendasi menu best seller secara proaktif',
                    'Jelaskan rasa menu dengan singkat dan menarik',
                    'Tawarkan menu yang sedang populer atau favorit pelanggan lain',
                    'Beri waktu pelanggan berpikir tanpa tekanan'
                ],
                donts: [
                    'Jangan menunjukkan ketidaksabaran saat pelanggan masih memilih',
                    'Jangan memberikan terlalu banyak pilihan sekaligus',
                    'Jangan meninggalkan pelanggan sendirian tanpa bantuan',
                    'Jangan memaksa pelanggan untuk segera memutuskan'
                ],
                scripts: [
                    '"Kalau Kakak suka yang manis dan creamy, Caramel Macchiato kami best seller loh Kak! Atau kalau mau coba yang unik, Matcha Espresso Fusion juga favorit pelanggan kami."',
                    '"Tenang aja Kak, santai pilihnya. Kalau mau saya rekomendasikan yang paling laris hari ini: Vanilla Latte dan Kopi Gula Aren!"'
                ],
                menuKeywords: ['Caramel Macchiato', 'Vanilla Latte', 'Matcha Latte', 'Latte', 'Kopi Gula Aren', 'Mocha'],
                menuReason: 'Menu best seller dan populer yang aman direkomendasikan ke pelanggan yang masih bimbang.'
            },
            M04: {
                code: 'M04',
                name: 'Puas / Ramah',
                subtitle: 'Pelanggan dalam suasana hati yang baik dan ramah',
                icon: 'bi-emoji-laughing-fill',
                color: '#22c55e',
                bgSoft: 'rgba(34, 197, 94, 0.15)',
                dos: [
                    'Balas senyuman dan sapa dengan hangat dan antusias',
                    'Tawarkan menu seasonal atau menu spesial baru',
                    'Ajak obrolan ringan dan berikan pengalaman personal',
                    'Ucapkan terima kasih dan doa semoga hari pelanggan menyenangkan'
                ],
                donts: [
                    'Jangan merespon datar atau tidak antusias',
                    'Jangan terburu-buru mengakhiri interaksi positif',
                    'Jangan melupakan ucapan terima kasih',
                    'Jangan mengabaikan pujian dari pelanggan'
                ],
                scripts: [
                    '"Halo Kak! Senang sekali hari ini Kakak berkunjung. Mau coba racikan spesial barista kami hari ini? Matcha Espresso Fusion sedang promo spesial loh!"',
                    '"Terima kasih banyak atas kunjungannya Kak! Semoga harinya semakin menyenangkan. Sampai jumpa lagi ya!"'
                ],
                menuKeywords: ['Matcha Espresso Fusion', 'Affogato', 'Blue Ocean', 'Mojito Mint', 'Red Velvet Latte'],
                menuReason: 'Menu unik & spesial yang melengkapi suasana hati ceria pelanggan.'
            }
        };

        // ==========================================
        //  UI LOGIC
        // ==========================================

        function selectOption(el) {
            const group = el.closest('.mood-option-group');
            const question = group.dataset.question;

            // Toggle siblings
            group.querySelectorAll('.mood-option').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');

            answers[question] = el.dataset.value;
            checkReady();
        }

        function checkReady() {
            const allAnswered = answers.perasaan && answers.kebutuhan && answers.energi;
            document.getElementById('btnHitung').disabled = !allAnswered;

            const answered = [answers.perasaan, answers.kebutuhan, answers.energi].filter(Boolean).length;
            document.getElementById('statusText').textContent =
                allAnswered ? '✓ Semua pertanyaan telah dijawab — siap analisis!'
                            : `${answered}/3 pertanyaan dijawab`;
        }

        function resetForm() {
            answers.perasaan = null;
            answers.kebutuhan = null;
            answers.energi = null;

            document.querySelectorAll('.mood-option').forEach(o => o.classList.remove('selected'));
            document.getElementById('btnHitung').disabled = true;
            document.getElementById('statusText').textContent = 'Pilih jawaban untuk ketiga pertanyaan di atas';
            document.getElementById('emptyState').style.display = 'block';
            document.getElementById('resultPanel').classList.remove('show');
        }

        // ==========================================
        //  CERTAINTY FACTOR ENGINE
        // ==========================================

        function hitungMood() {
            // Collect all evidences from answers
            const allEvidences = { M01: [], M02: [], M03: [], M04: [] };

            // For each answered question, get the CF weights
            for (const [question, answer] of Object.entries(answers)) {
                if (!answer) continue;
                const weights = knowledgeBase[question][answer];
                if (!weights) continue;

                for (const [mood, cfPakar] of Object.entries(weights)) {
                    if (cfPakar > 0) {
                        // CF_user = 1.0 (pelanggan menjawab sendiri, bukan tebakan)
                        const cfHE = cfPakar * 1.0;
                        allEvidences[mood].push(cfHE);
                    }
                }
            }

            // Calculate CF Combine for each mood
            const moodScores = {};
            for (const [mood, evidences] of Object.entries(allEvidences)) {
                if (evidences.length === 0) {
                    moodScores[mood] = 0;
                    continue;
                }
                let cfCombine = evidences[0];
                for (let i = 1; i < evidences.length; i++) {
                    cfCombine = cfCombine + evidences[i] * (1 - cfCombine);
                }
                moodScores[mood] = Math.min(1.0, Math.max(0, cfCombine));
            }

            // Sort and find dominant
            const sorted = Object.entries(moodScores)
                .map(([code, cf]) => ({ code, cf, pct: (cf * 100).toFixed(1) }))
                .sort((a, b) => b.cf - a.cf);

            const dominant = sorted[0];
            renderResult(dominant, sorted);
        }

        // ==========================================
        //  RENDER RESULT
        // ==========================================

        function renderResult(dominant, allMoods) {
            const def = moodDefs[dominant.code];

            // Hide empty, show result
            document.getElementById('emptyState').style.display = 'none';
            const panel = document.getElementById('resultPanel');
            panel.classList.remove('show');
            // Force reflow for animation
            void panel.offsetWidth;
            panel.classList.add('show');

            // Mood badge
            document.getElementById('resultMoodCode').textContent = dominant.code;
            document.getElementById('resultMoodCode').style.background = def.bgSoft;
            document.getElementById('resultMoodCode').style.color = def.color;

            const badge = document.getElementById('resultMoodBadge');
            badge.style.background = def.bgSoft;
            badge.style.color = def.color;
            badge.style.border = `2px solid ${def.color}`;

            document.getElementById('resultMoodIcon').className = `bi ${def.icon}`;
            document.getElementById('resultMoodName').textContent = def.name;
            document.getElementById('resultMoodPct').textContent = dominant.pct + '%';
            document.getElementById('resultMoodPct').style.color = def.color;
            document.getElementById('resultMoodSubtitle').textContent = def.subtitle;

            // CF Meter
            document.getElementById('resultCfMeter').style.width = dominant.pct + '%';
            document.getElementById('resultCfMeter').style.background = def.color;

            // All moods bars
            const barsHtml = allMoods.map(m => {
                const d = moodDefs[m.code];
                const isBold = m.code === dominant.code;
                return `
                    <div class="mood-bar-row">
                        <span class="mood-bar-label" style="color: ${isBold ? d.color : '#9ca3af'}; ${isBold ? 'font-weight:700;' : ''}">
                            <i class="bi ${d.icon} me-1"></i>${d.name}
                        </span>
                        <div class="mood-bar-track">
                            <div class="mood-bar-track-fill" style="width: ${Math.max(2, m.pct)}%; background: ${d.color};"></div>
                        </div>
                        <span class="mood-bar-pct" style="color: ${isBold ? d.color : '#9ca3af'};">${m.pct}%</span>
                    </div>
                `;
            }).join('');
            document.getElementById('allMoodsBars').innerHTML = barsHtml;

            // DO's
            document.getElementById('resultDos').innerHTML = def.dos.map(d =>
                `<li><i class="bi bi-check-lg" style="color:#22c55e;"></i>${d}</li>`
            ).join('');

            // DON'TS
            document.getElementById('resultDonts').innerHTML = def.donts.map(d =>
                `<li><i class="bi bi-x-lg" style="color:#ef4444;"></i>${d}</li>`
            ).join('');

            // Script
            document.getElementById('resultScript').textContent = def.scripts[0];

            // Menu recommendations — match from real database
            const matchedMenus = [];
            def.menuKeywords.forEach(keyword => {
                const found = menuList.find(m =>
                    m.nama_kopi.toLowerCase().includes(keyword.toLowerCase()) &&
                    !matchedMenus.some(mm => mm.id === m.id)
                );
                if (found) matchedMenus.push(found);
            });

            if (matchedMenus.length === 0) {
                // Fallback: pick first 3 menus
                matchedMenus.push(...menuList.slice(0, 3));
            }

            document.getElementById('resultMenuCards').innerHTML = matchedMenus.slice(0, 4).map(menu => {
                const imgSrc = menu.gambar ? `/images/${menu.gambar}` : '/images/logo.jpg';
                const harga = new Intl.NumberFormat('id-ID').format(menu.harga);
                return `
                    <div class="menu-reco-card">
                        <img src="${imgSrc}" alt="${menu.nama_kopi}" class="menu-reco-img" onerror="this.src='/images/logo.jpg'">
                        <div class="flex-grow-1">
                            <div class="fw-bold small text-white">${menu.nama_kopi}</div>
                            <div class="small text-muted">${menu.kategori}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold small" style="color: var(--gold-light);">Rp ${harga}</div>
                        </div>
                    </div>
                `;
            }).join('') + `
                <div class="small text-muted mt-1">
                    <i class="bi bi-info-circle me-1"></i> ${def.menuReason}
                </div>
            `;

            // Scroll to result on mobile
            if (window.innerWidth < 992) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // ==========================================
        //  COPY SCRIPT
        // ==========================================

        function copyScript() {
            const text = document.getElementById('resultScript').textContent;
            const clean = text.replace(/^"|"$/g, '').trim();
            navigator.clipboard.writeText(clean).then(() => {
                const btn = document.querySelector('.btn-copy-script');
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Tersalin!';
                btn.style.background = 'var(--gold)';
                btn.style.color = 'var(--dark-base)';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> Salin';
                    btn.style.background = 'rgba(200, 155, 60, 0.2)';
                    btn.style.color = 'var(--gold-light)';
                }, 2000);
            });
        }
    </script>
</body>
</html>
