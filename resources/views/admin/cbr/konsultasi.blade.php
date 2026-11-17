<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Penanganan Masalah (CBR) — NOIR COFFEE Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cbr-brown: #6f4e37;
            --cbr-brown-dark: #4a3221;
            --cbr-warm: #b28157;
            --cbr-cream: #f4ece4;
            --cbr-cream-dark: #e8d9cc;
            --cbr-bg: #f8f6f3;
            --noir-gold: #c89b3c;
            --noir-gold-dark: #9b7625;
            --dark-card: #201808;
        }

        body {
            background-color: var(--cbr-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2b2b;
            padding-bottom: 60px;
        }

        /* Top Navbar */
        .admin-nav {
            background: #ffffff;
            border-bottom: 1px solid #e7ded4;
            padding: 14px 28px;
            box-shadow: 0 2px 12px rgba(111, 78, 55, 0.05);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--cbr-brown-dark);
            text-decoration: none;
        }

        .btn-nav-cbr {
            background: #ffffff;
            border: 1px solid var(--cbr-cream-dark);
            color: var(--cbr-brown-dark);
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-nav-cbr:hover, .btn-nav-cbr.active {
            background: var(--cbr-brown);
            color: #ffffff;
            border-color: var(--cbr-brown);
        }

        /* Hero Banner matching image style */
        .hero-banner {
            background: linear-gradient(135deg, #e9dbce 0%, #f4ece4 100%);
            border: 1px solid #d9c5b2;
            border-radius: 24px;
            padding: 28px 32px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(111, 78, 55, 0.08);
        }

        .hero-badge-tag {
            background: var(--cbr-brown);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--cbr-brown-dark);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            color: #6c5a4d;
            font-size: 14px;
            max-width: 680px;
            margin-bottom: 0;
        }

        /* 4-Step Cycle Flow Cards */
        .cbr-cycle-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 16px;
            padding: 16px;
            transition: all 0.2s;
            height: 100%;
            box-shadow: 0 4px 12px rgba(111, 78, 55, 0.04);
        }
        .cbr-cycle-card:hover {
            transform: translateY(-2px);
            border-color: var(--cbr-warm);
        }

        .step-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--cbr-brown);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            margin-right: 8px;
        }

        .step-name {
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 1px;
            color: var(--cbr-brown-dark);
        }

        .step-desc {
            font-size: 12px;
            color: #7a6a5d;
            margin-top: 6px;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Content Cards */
        .noir-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(111, 78, 55, 0.05);
            margin-bottom: 24px;
        }

        .card-header-cbr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f0e6dc;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .card-header-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--cbr-brown-dark);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        /* Quick Example Pills */
        .example-pill {
            background: #ede2d5;
            border: 1px dashed var(--cbr-warm);
            color: var(--cbr-brown-dark);
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .example-pill:hover {
            background: var(--cbr-brown);
            color: #ffffff;
            border-style: solid;
        }

        /* Tags in selector */
        .tag-select-btn {
            background: #f7f3ee;
            border: 1px solid #dccfc2;
            color: #4a3c31;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
            display: inline-block;
            margin: 3px;
        }
        .tag-select-btn:hover {
            border-color: var(--cbr-brown);
            background: #efe5d9;
        }
        .tag-select-btn.active {
            background: var(--cbr-brown);
            color: #ffffff;
            border-color: var(--cbr-brown);
        }

        /* Similarity Gauge */
        .similarity-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: conic-gradient(var(--cbr-brown) calc(var(--pct) * 1%), #e4d7cc 0);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .similarity-circle::before {
            content: '';
            position: absolute;
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: #ffffff;
        }
        .similarity-val {
            position: relative;
            font-size: 18px;
            font-weight: 800;
            color: var(--cbr-brown-dark);
            font-family: monospace;
        }

        .step-checklist {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .step-checklist li {
            padding: 8px 12px;
            border-radius: 8px;
            background: #fbf9f6;
            border: 1px solid #f0e6dc;
            margin-bottom: 6px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .step-checklist li i {
            color: #16a34a;
            margin-top: 2px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <header class="admin-nav d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('dashboard') }}" class="brand-badge">
                <i class="bi bi-cup-hot-fill" style="color: var(--cbr-brown);"></i>
                <span>NOIR COFFEE</span>
            </a>
            <span class="badge bg-secondary text-uppercase px-2 py-1" style="font-size: 10px; letter-spacing: 1px;">
                Admin Only
            </span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('dashboard') }}" class="btn-nav-cbr">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.cbr.konsultasi') }}" class="btn-nav-cbr active">
                <i class="bi bi-search"></i> Solusi Masalah (CBR)
            </a>
            <a href="{{ route('admin.cbr.index') }}" class="btn-nav-cbr">
                <i class="bi bi-database-check"></i> Basis Kasus (Case Base)
            </a>
            <a href="{{ route('admin.cbr.create') }}" class="btn-nav-cbr">
                <i class="bi bi-plus-circle"></i> Tambah Kasus
            </a>
        </div>
    </header>

    <div class="container py-4" style="max-width: 1140px;">

        <!-- ALERTS -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" style="background: rgba(34, 197, 94, 0.15); border: 1px solid #22c55e; color: #15803d;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm border-0 mb-4" style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #b91c1c;">
                <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Mohon periksa input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- HERO BANNER (MATCHING SLIDE POSTER) -->
        <div class="hero-banner">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="hero-badge-tag">Sistem Pakar &bull; Case Based Reasoning (CBR)</span>
                    <h1 class="hero-title">PENANGANAN MASALAH OPERASIONAL</h1>
                    <p class="hero-subtitle">
                        <strong>Tujuan:</strong> Membantu admin & supervisor menemukan solusi pemecahan masalah operasional (mesin, grinder, bahan, peralatan) secara otomatis berdasarkan kasus terdahulu yang pernah terjadi.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-4" style="background: rgba(255,255,255,0.7); border: 1px solid #d9c5b2;">
                        <i class="bi bi-gear-wide-connected fs-3" style="color: var(--cbr-brown);"></i>
                        <div class="text-start">
                            <div class="small fw-bold" style="color: var(--cbr-brown-dark);">Siklus CBR 4 Tahap</div>
                            <div class="text-muted" style="font-size: 11px;">Retrieve &bull; Reuse &bull; Revise &bull; Retain</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIKLUS 4 TAHAP VISUAL -->
            <div class="row g-2 mt-3 pt-3 border-top" style="border-color: rgba(111,78,55,0.15) !important;">
                <div class="col-md-3 col-6">
                    <div class="cbr-cycle-card">
                        <div class="d-flex align-items-center">
                            <span class="step-num">1</span>
                            <span class="step-name">RETRIEVE</span>
                        </div>
                        <p class="step-desc">Mencari kasus terdahulu yang paling mirip dari Case Base.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="cbr-cycle-card">
                        <div class="d-flex align-items-center">
                            <span class="step-num">2</span>
                            <span class="step-name">REUSE</span>
                        </div>
                        <p class="step-desc">Menggunakan rekomendasi solusi dari kasus serupa.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="cbr-cycle-card">
                        <div class="d-flex align-items-center">
                            <span class="step-num">3</span>
                            <span class="step-name">REVISE</span>
                        </div>
                        <p class="step-desc">Menyesuaikan solusi jika ada perbedaan kondisi.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="cbr-cycle-card">
                        <div class="d-flex align-items-center">
                            <span class="step-num">4</span>
                            <span class="step-name">RETAIN</span>
                        </div>
                        <p class="step-desc">Menyimpan kasus baru untuk memperkaya Case Base.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK EXAMPLE CASES (FROM SLIDE POSTER) -->
        <div class="noir-card p-3 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span class="fw-bold small text-muted text-uppercase" style="letter-spacing: 1px;">
                    <i class="bi bi-lightbulb-fill text-warning me-1"></i> Contoh Kasus Cepat (Klik untuk Uji):
                </span>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="example-pill" onclick="fillExample('Mesin Espresso', ['Rasa kopi sangat pahit', 'After taste tidak enak'], ['Durasi ekstraksi terlalu lama', 'Suhu air terlalu tinggi'])">
                        ☕ Kopi terlalu pahit &rarr; <span class="text-muted">Durasi ekstraksi</span>
                    </button>
                    <button type="button" class="example-pill" onclick="fillExample('Mesin Espresso', ['Espresso terlihat encer', 'Crema tipis atau tidak ada'], ['Dosis bubuk kopi kurang', 'Grind size terlalu kasar'])">
                        💧 Kopi terlalu encer &rarr; <span class="text-muted">Dosis bubuk</span>
                    </button>
                    <button type="button" class="example-pill" onclick="fillExample('Mesin Espresso', ['Air tidak keluar dari group head', 'Suara pompa abnormal'], ['Saluran air tersumbat', 'Tangki air kosong'])">
                        🚫 Mesin tidak keluar air &rarr; <span class="text-muted">Saluran air</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN 2-COLUMN SECTION -->
        <div class="row g-4">

            <!-- LEFT COLUMN: INPUT MASALAH -->
            <div class="col-lg-5">
                <div class="noir-card">
                    <div class="card-header-cbr">
                        <h5 class="card-header-title">
                            <i class="bi bi-input-cursor-text" style="color: var(--cbr-brown);"></i>
                            <span>Input Masalah yang Terjadi</span>
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="resetForm()">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                    </div>

                    <form action="{{ route('admin.cbr.proses') }}" method="POST" id="cbrForm">
                        @csrf

                        <!-- 1. Kategori Masalah -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">1. Jenis Masalah (Kategori)</label>
                            <select name="kategori_masalah" id="kategoriInput" class="form-select form-select-lg rounded-3" required style="border-color: #dccfc2; font-size: 14px;">
                                <option value="" disabled selected>-- Pilih Jenis Masalah --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ (old('kategori_masalah', request('kategori_masalah')) == $kat) ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Gejala Permasalahan -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted d-flex justify-content-between">
                                <span>2. Gejala Permasalahan</span>
                                <span class="text-muted" style="font-size: 11px;">Pilih atau ketik</span>
                            </label>

                            <!-- Quick Tag selector -->
                            <div class="p-2 rounded-3 mb-2" style="background: #faf7f4; border: 1px dashed #d9c5b2; max-height: 140px; overflow-y: auto;">
                                <div class="text-muted mb-1" style="font-size: 11px;">Klik tanda gejala yang dialami:</div>
                                @foreach($allGejala as $g)
                                    <span class="tag-select-btn" onclick="toggleTag(this, 'gejalaContainer', 'gejala[]')">
                                        + {{ $g }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Selected / Active inputs container -->
                            <div id="gejalaContainer">
                                @php
                                    $oldGejala = old('gejala', request('gejala', ['']));
                                @endphp
                                @foreach($oldGejala as $idx => $val)
                                    <div class="input-group mb-1 gejala-row">
                                        <input type="text" name="gejala[]" class="form-control form-control-sm rounded-start-2" placeholder="Contoh: Rasa kopi sangat pahit" value="{{ $val }}" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 mt-1" style="color: var(--cbr-brown); font-weight: 600;" onclick="addRow('gejalaContainer', 'gejala[]', 'Ketik gejala lainnya...')">
                                <i class="bi bi-plus-circle"></i> Tambah Gejala Manual
                            </button>
                        </div>

                        <!-- 3. Kondisi yang Terjadi -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted d-flex justify-content-between">
                                <span>3. Kondisi yang Terjadi</span>
                                <span class="text-muted" style="font-size: 11px;">Pilih atau ketik</span>
                            </label>

                            <!-- Quick Tag selector -->
                            <div class="p-2 rounded-3 mb-2" style="background: #faf7f4; border: 1px dashed #d9c5b2; max-height: 140px; overflow-y: auto;">
                                <div class="text-muted mb-1" style="font-size: 11px;">Klik kondisi teramati:</div>
                                @foreach($allKondisi as $k)
                                    <span class="tag-select-btn" onclick="toggleTag(this, 'kondisiContainer', 'kondisi[]')">
                                        + {{ $k }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Selected / Active inputs container -->
                            <div id="kondisiContainer">
                                @php
                                    $oldKondisi = old('kondisi', request('kondisi', ['']));
                                @endphp
                                @foreach($oldKondisi as $idx => $val)
                                    <div class="input-group mb-1 kondisi-row">
                                        <input type="text" name="kondisi[]" class="form-control form-control-sm rounded-start-2" placeholder="Contoh: Durasi ekstraksi terlalu lama" value="{{ $val }}" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 mt-1" style="color: var(--cbr-brown); font-weight: 600;" onclick="addRow('kondisiContainer', 'kondisi[]', 'Ketik kondisi lainnya...')">
                                <i class="bi bi-plus-circle"></i> Tambah Kondisi Manual
                            </button>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn w-100 py-3 rounded-3 fw-bold text-white shadow-sm" style="background: var(--cbr-brown); font-size: 15px;">
                            <i class="bi bi-cpu-fill me-1"></i> Proses Inferensi CBR (Retrieve &amp; Reuse)
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT COLUMN: HASIL INFERENSI (RETRIEVE, REUSE, REVISE, RETAIN) -->
            <div class="col-lg-7">
                @if(isset($reuseSolution) && $reuseSolution)
                    @php
                        $best = $retrieveResults[0];
                        $case = $best['case'];
                        $simPct = $best['similarity_pct'];
                    @endphp

                    <!-- BEST MATCH OUTPUT (REUSE) -->
                    <div class="noir-card border-2" style="border-color: var(--cbr-warm) !important;">
                        <div class="card-header-cbr">
                            <div>
                                <span class="badge text-uppercase px-2 py-1 mb-1" style="background: #e9dbce; color: var(--cbr-brown-dark); font-weight: 700;">
                                    <i class="bi bi-check2-circle me-1"></i> Solusi Rekomendasi (Reuse)
                                </span>
                                <h5 class="fw-bold mb-0 text-dark">
                                    {{ $case->judul_masalah }}
                                </h5>
                                <span class="text-muted small">Referensi Kasus: <strong class="text-dark">{{ $case->kode_kasus }}</strong> &bull; Kategori: {{ $case->kategori_masalah }}</span>
                            </div>

                            <!-- Similarity Gauge -->
                            <div class="text-center">
                                <div class="similarity-circle" style="--pct: {{ min(100, $simPct) }};">
                                    <span class="similarity-val">{{ $simPct }}%</span>
                                </div>
                                <span class="text-muted d-block mt-1" style="font-size: 10px; font-weight: 700;">SIMILARITY</span>
                            </div>
                        </div>

                        <!-- Catatan Kecocokan -->
                        <div class="alert alert-light border rounded-3 p-2 px-3 mb-3 d-flex align-items-center gap-2 small">
                            <i class="bi bi-info-circle-fill" style="color: var(--cbr-brown);"></i>
                            <span>{{ $reuseSolution['catatan'] }}</span>
                        </div>

                        <!-- Detail Similarity Breakdown -->
                        <div class="p-3 rounded-3 mb-3" style="background: #fbf9f6; border: 1px solid #ebdcd0;">
                            <div class="small fw-bold text-muted mb-2 text-uppercase" style="font-size: 11px;">Komponen Kemiripan Kasus:</div>
                            <div class="row g-2 text-center" style="font-size: 12px;">
                                <div class="col-4">
                                    <div class="p-2 rounded bg-white border">
                                        <div class="text-muted">Kategori</div>
                                        <div class="fw-bold fs-6 {{ $best['detail']['kategori']['match'] ? 'text-success' : 'text-danger' }}">
                                            {{ $best['detail']['kategori']['similarity'] }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded bg-white border">
                                        <div class="text-muted">Gejala Cocok</div>
                                        <div class="fw-bold fs-6 text-dark">{{ $best['detail']['gejala']['similarity'] }}%</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 rounded bg-white border">
                                        <div class="text-muted">Kondisi Cocok</div>
                                        <div class="fw-bold fs-6 text-dark">{{ $best['detail']['kondisi']['similarity'] }}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Solusi Utama -->
                        <div class="mb-3">
                            <label class="fw-bold text-muted small text-uppercase" style="letter-spacing: 0.5px;">Solusi Penanganan:</label>
                            <div class="p-3 rounded-3 mt-1" style="background: #f4ece4; border: 1px solid #e1cfbf; font-weight: 600; color: #3b281b; line-height: 1.6;">
                                <i class="bi bi-wrench-adjustable me-1"></i> {{ $case->solusi }}
                            </div>
                        </div>

                        <!-- Langkah Penanganan -->
                        @if(!empty($case->langkah_penanganan))
                            <div class="mb-4">
                                <label class="fw-bold text-muted small text-uppercase mb-2" style="letter-spacing: 0.5px;">Langkah Penanganan Detail:</label>
                                <ul class="step-checklist">
                                    @foreach($case->langkah_penanganan as $step)
                                        <li>
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>{{ $step }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- REVISE & RETAIN SECTION -->
                        <div class="p-3 rounded-3" style="background: #faf7f3; border: 1px solid #e4d7cc;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-dark">
                                    <i class="bi bi-arrow-repeat me-1" style="color: var(--cbr-brown);"></i>
                                    Tahap 3 &amp; 4: Revise &amp; Retain
                                </span>
                                <span class="text-muted" style="font-size: 11px;">Pelajari Kasus Baru</span>
                            </div>
                            <p class="text-muted small mb-2">
                                Jika solusi di atas perlu disesuaikan atau merupakan variasi kasus baru di coffee shop, simpan ke Case Base agar sistem semakin pintar.
                            </p>
                            <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#retainCollapse">
                                <i class="bi bi-pencil-square"></i> Buka Form Penyesuaian &amp; Simpan Kasus (Retain)
                            </button>

                            <!-- Retain Form Collapse -->
                            <div class="collapse mt-3" id="retainCollapse">
                                <form action="{{ route('admin.cbr.retain') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kategori_masalah" value="{{ request('kategori_masalah') }}">
                                    @foreach(request('gejala', []) as $g)
                                        <input type="hidden" name="gejala[]" value="{{ $g }}">
                                    @endforeach
                                    @foreach(request('kondisi', []) as $k)
                                        <input type="hidden" name="kondisi[]" value="{{ $k }}">
                                    @endforeach

                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Judul Masalah Disesuaikan:</label>
                                        <input type="text" name="judul_masalah" class="form-control form-control-sm" value="{{ $case->judul_masalah }} (Revisi)" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Solusi Disesuaikan (Revise):</label>
                                        <textarea name="solusi" rows="2" class="form-control form-control-sm" required>{{ $case->solusi }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm text-white fw-bold rounded-pill px-4" style="background: var(--cbr-brown);">
                                        <i class="bi bi-save me-1"></i> Simpan ke Case Base (Retain)
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- ALTERNATIVE MATCHES -->
                    @if(count($retrieveResults) > 1)
                        <div class="noir-card">
                            <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">
                                Kasus Serupa Lainnya (Ranked Matches):
                            </h6>
                            <div class="list-group list-group-flush">
                                @foreach(array_slice($retrieveResults, 1, 3) as $alt)
                                    @php $altCase = $alt['case']; @endphp
                                    <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold small text-dark">{{ $altCase->judul_masalah }}</div>
                                            <div class="text-muted" style="font-size: 11px;">{{ $altCase->kode_kasus }} &bull; {{ $altCase->kategori_masalah }}</div>
                                        </div>
                                        <span class="badge rounded-pill" style="background: #ede2d5; color: var(--cbr-brown-dark); font-family: monospace;">
                                            {{ $alt['similarity_pct'] }}%
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @else
                    <!-- EMPTY PLACEHOLDER -->
                    <div class="noir-card text-center py-5">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #ede2d5; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; color: var(--cbr-brown); margin-bottom: 16px;">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Menunggu Input Masalah</h5>
                        <p class="text-muted small mb-0" style="max-width: 400px; margin: 0 auto;">
                            Pilih jenis masalah, pilih gejala yang dialami, dan kondisi yang teramati di sebelah kiri. Sistem Case Based Reasoning akan mencocokkan kasus terdahulu dan menyajikan solusi terbaik.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle tag from selector to input list
        function toggleTag(el, containerId, inputName) {
            const container = document.getElementById(containerId);
            const text = el.innerText.replace(/^\+\s*/, '').trim();

            // Check if already in container
            const existingInputs = container.querySelectorAll('input[type="text"]');
            let found = null;
            existingInputs.forEach(input => {
                if (input.value.trim().toLowerCase() === text.toLowerCase()) {
                    found = input;
                }
            });

            if (found) {
                // If it's the only empty input, don't remove, just clear
                if (existingInputs.length > 1) {
                    found.closest('.input-group').remove();
                } else {
                    found.value = '';
                }
                el.classList.remove('active');
            } else {
                // Fill first empty input or add new row
                let emptyInput = Array.from(existingInputs).find(i => i.value.trim() === '');
                if (emptyInput) {
                    emptyInput.value = text;
                } else {
                    addRow(containerId, inputName, '', text);
                }
                el.classList.add('active');
            }
        }

        function addRow(containerId, inputName, placeholder = '', val = '') {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'input-group mb-1';
            div.innerHTML = `
                <input type="text" name="${inputName}" class="form-control form-control-sm rounded-start-2" placeholder="${placeholder}" value="${val}" required>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                    <i class="bi bi-x"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function removeRow(btn) {
            const container = btn.closest('#gejalaContainer, #kondisiContainer');
            const rows = container.querySelectorAll('.input-group');
            if (rows.length > 1) {
                btn.closest('.input-group').remove();
            } else {
                // If only 1 left, just clear value
                btn.closest('.input-group').querySelector('input').value = '';
            }
        }

        function resetForm() {
            document.getElementById('cbrForm').reset();
            document.querySelectorAll('.tag-select-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('gejalaContainer').innerHTML = `
                <div class="input-group mb-1">
                    <input type="text" name="gejala[]" class="form-control form-control-sm rounded-start-2" placeholder="Contoh: Rasa kopi sangat pahit" required>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                </div>
            `;
            document.getElementById('kondisiContainer').innerHTML = `
                <div class="input-group mb-1">
                    <input type="text" name="kondisi[]" class="form-control form-control-sm rounded-start-2" placeholder="Contoh: Durasi ekstraksi terlalu lama" required>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                </div>
            `;
        }

        // Fill example cases from the poster
        function fillExample(kategori, gejalaList, kondisiList) {
            resetForm();
            document.getElementById('kategoriInput').value = kategori;

            const gejalaCont = document.getElementById('gejalaContainer');
            gejalaCont.innerHTML = '';
            gejalaList.forEach(g => {
                addRow('gejalaContainer', 'gejala[]', '', g);
            });

            const kondisiCont = document.getElementById('kondisiContainer');
            kondisiCont.innerHTML = '';
            kondisiList.forEach(k => {
                addRow('kondisiContainer', 'kondisi[]', '', k);
            });

            // Automatically submit for seamless testing
            document.getElementById('cbrForm').submit();
        }
    </script>
</body>
</html>
