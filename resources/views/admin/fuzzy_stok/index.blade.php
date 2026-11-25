<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Rekomendasi Stok (Fuzzy Logic) — Noir Coffee Admin</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --noir-dark: #2D1B14;
            --noir-brown: #6F4E37;
            --noir-brown-light: #8C6249;
            --noir-gold: #C89B3C;
            --noir-cream: #F5EBE1;
            --noir-cream-soft: #FAF6F0;
            --noir-bg: #F4EFEB;
            --status-danger: #B94A48;
            --status-warning: #D99B26;
            --status-safe: #4E7852;
        }

        body {
            background-color: var(--noir-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2b2b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLES (MATCHES NOIR ADMIN) */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #f3e7dc;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px;
            overflow-y: auto;
            z-index: 1040;
            border-right: 1px solid #e5d5c5;
            transition: transform 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--noir-gold);
            border-radius: 10px;
        }

        .logo {
            font-size: 32px;
            font-weight: 800;
            color: #2b2b2b;
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: #4a3b32;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            background: #e6d3c2;
            color: var(--noir-dark);
            transform: translateX(4px);
        }

        .menu-link.active {
            background: var(--noir-brown);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(111, 78, 55, 0.25);
        }

        .sidebar-section {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8c786a;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 8px;
            padding-left: 10px;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 12px;
            font-weight: 600;
            margin-top: 20px;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        /* MAIN CONTENT AREA */
        .main-wrapper {
            margin-left: 280px;
            min-height: 100vh;
            padding: 30px 40px 60px;
            transition: margin 0.3s ease;
        }

        .top-navbar-mobile {
            display: none;
            background: #ffffff;
            padding: 14px 20px;
            border-bottom: 1px solid #e5d5c5;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1030;
        }

        /* CARDS & THEME */
        .noir-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 4px 20px rgba(111, 78, 55, 0.05);
            margin-bottom: 24px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 4px 16px rgba(111, 78, 55, 0.05);
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(111, 78, 55, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
        }

        .stat-card.danger::before { background: var(--status-danger); }
        .stat-card.warning::before { background: var(--status-warning); }
        .stat-card.safe::before { background: var(--status-safe); }
        .stat-card.total::before { background: var(--noir-gold); }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: var(--noir-dark);
            line-height: 1;
            margin-top: 8px;
        }

        /* FUZZY BADGES */
        .badge-fuzzy {
            font-weight: 700;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.3px;
        }

        .badge-danger-fuzzy {
            background: #fdf2f2;
            color: var(--status-danger);
            border: 1px solid #f5c2c7;
        }

        .badge-warning-fuzzy {
            background: #fef9e7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-success-fuzzy {
            background: #f0fdf4;
            color: var(--status-safe);
            border: 1px solid #bbf7d0;
        }

        /* TABS STYLING */
        .nav-tabs-noir {
            border-bottom: 2px solid #e7ded4;
            gap: 10px;
            margin-bottom: 24px;
        }

        .nav-tabs-noir .nav-link {
            border: none;
            background: transparent;
            color: #6b5c51;
            font-weight: 700;
            font-size: 15px;
            padding: 12px 24px;
            border-radius: 12px 12px 0 0;
            position: relative;
            transition: all 0.2s ease;
        }

        .nav-tabs-noir .nav-link:hover {
            color: var(--noir-dark);
            background: #f4ece4;
        }

        .nav-tabs-noir .nav-link.active {
            color: var(--noir-dark);
            background: #ffffff;
            border-bottom: 3px solid var(--noir-brown);
        }

        /* TABLE */
        .table-fuzzy th {
            background: #3e271c;
            color: #ffffff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            padding: 14px 16px;
            border: none;
        }

        .table-fuzzy td {
            padding: 16px;
            vertical-align: middle;
            font-size: 13px;
            border-bottom: 1px solid #f0e6dc;
            background: #ffffff;
        }

        .table-fuzzy tr:hover td {
            background-color: #faf6f2;
        }

        /* BUTTONS */
        .btn-gold {
            background: var(--noir-gold);
            color: #140f05;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 20px;
            border: none;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: #b88628;
            color: #140f05;
        }

        .btn-brown {
            background: var(--noir-brown);
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 20px;
            border: none;
            transition: all 0.2s;
        }

        .btn-brown:hover {
            background: #5a3e2b;
            color: #ffffff;
        }

        .btn-action-restock {
            background: #fdf2f2;
            border: 1px solid #f5c2c7;
            color: var(--status-danger);
            font-weight: 700;
            font-size: 12px;
            border-radius: 8px;
            padding: 6px 12px;
            transition: all 0.2s;
        }

        .btn-action-restock:hover {
            background: var(--status-danger);
            color: #ffffff;
        }

        /* PROGRESS BARS */
        .stock-progress {
            height: 8px;
            border-radius: 4px;
            background: #ede3d8;
            overflow: hidden;
            margin-top: 6px;
        }

        .stock-progress .bar {
            height: 100%;
            border-radius: 4px;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                padding: 20px;
            }
            .top-navbar-mobile {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR OVERLAY (MOBILE) -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- MOBILE NAVBAR -->
<div class="top-navbar-mobile shadow-sm">
    <div class="fw-bold" style="font-family: 'Playfair Display', serif; font-size: 20px; color: var(--noir-dark);">
        ☕ Noir Coffee Admin
    </div>
    <button class="btn btn-outline-dark btn-sm rounded-3" onclick="toggleSidebar()">
        <i class="bi bi-list fs-5"></i>
    </button>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        ☕ Noir Coffee
    </div>

    <a href="/dashboard" class="menu-link">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="/menu" class="menu-link">
        <i class="bi bi-journal-text"></i> Menu Edit Kopi
    </a>

    <a href="/pesanan" class="menu-link">
        <i class="bi bi-box-seam"></i> Data Pesanan
    </a>

    <a href="/status-pesanan" class="menu-link">
        <i class="bi bi-person-workspace"></i> Status Pesanan
    </a>

    <a href="/admin/reservasi" class="menu-link">
        <i class="bi bi-calendar-check"></i> Reservasi
    </a>

    <!-- SISTEM PAKAR REKOMENDASI STOK (FUZZY) -->
    <div class="sidebar-section">
        📦 Pengelolaan Stok (Fuzzy)
    </div>

    <a href="{{ route('admin.fuzzy-stok.index') }}" class="menu-link active">
        <i class="bi bi-boxes"></i> Rekomendasi Stok (Fuzzy)
    </a>

    <!-- SISTEM PAKAR KOPI -->
    <div class="sidebar-section">
        ☕ Sistem Pakar Kopi
    </div>

    <a href="{{ route('admin.aturan.index') }}" class="menu-link">
        <i class="bi bi-file-earmark-ruled"></i> Aturan Rekomendasi
    </a>

    <a href="{{ route('admin.pertanyaan.index') }}" class="menu-link">
        <i class="bi bi-question-circle"></i> Pertanyaan Konsultasi
    </a>

    <a href="{{ route('admin.riwayat.index') }}" class="menu-link">
        <i class="bi bi-clock-history"></i> Riwayat Konsultasi
    </a>

    <!-- PENANGANAN MASALAH (CBR) -->
    <div class="sidebar-section">
        🛠️ Penanganan Masalah (CBR)
    </div>

    <a href="{{ route('admin.cbr.konsultasi') }}" class="menu-link">
        <i class="bi bi-search"></i> Solusi Masalah Operasional
    </a>

    <a href="{{ route('admin.cbr.index') }}" class="menu-link">
        <i class="bi bi-book"></i> Basis Kasus (Case Base)
    </a>

    <!-- KASIR & KARYAWAN -->
    <div class="sidebar-section">
        🛒 Kasir & Karyawan
    </div>

    <a href="{{ route('kasir.index') }}" class="menu-link" style="color: #c89b3c;">
        <i class="bi bi-calculator"></i> Buka Kasir POS
    </a>

    <a href="{{ route('admin.karyawan.index') }}" class="menu-link">
        <i class="bi bi-people"></i> Kelola Karyawan
    </a>

    <a href="/menu-pelanggan" class="menu-link">
        <i class="bi bi-globe"></i> Website Pelanggan
    </a>

    <form action="/logout" method="POST">
        @csrf
        <button class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<!-- MAIN CONTENT WRAPPER -->
<div class="main-wrapper">

    <!-- HEADER TITLE & BREADCRUMB -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2 text-muted" style="font-size: 13px;">
                <a href="/dashboard" class="text-decoration-none text-muted">Dashboard</a>
                <span>/</span>
                <span class="text-dark fw-bold">Sistem Pakar Stok Fuzzy</span>
            </div>
            <h1 class="h2 fw-bold m-0" style="color: var(--noir-dark); font-family: 'Playfair Display', serif;">
                📦 Sistem Pakar Rekomendasi Stok Bahan Baku
            </h1>
            <p class="text-muted m-0 mt-1" style="font-size: 14px;">
                Inferensi Fuzzy Logic (Metode Tsukamoto / Mamdani) untuk optimasi inventaris, pencegahan stock-out, dan estimasi kuantitas restok.
            </p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-gold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBahan">
                <i class="bi bi-plus-circle-fill me-1"></i> Tambah Bahan Baku
            </button>
        </div>
    </div>

    <!-- ALERT NOTIFICATION -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert" style="background: #f0fdf4; border-color: #bbf7d0; color: #15803D;">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <ul class="m-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- STAT SUMMARY CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card total">
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 13px; font-weight: 600;">
                    <span>Total Bahan Baku</span>
                    <i class="bi bi-boxes fs-4 text-warning"></i>
                </div>
                <div class="stat-number">{{ count($bahanBakus) }}</div>
                <div class="text-muted mt-2" style="font-size: 12px;">Terdaftar di sistem inventaris</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card danger">
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 13px; font-weight: 600;">
                    <span>Restok Segera</span>
                    <i class="bi bi-exclamation-triangle-fill fs-4" style="color: var(--status-danger);"></i>
                </div>
                <div class="stat-number" style="color: var(--status-danger);">{{ $restokSegeraCount }}</div>
                <div class="mt-2" style="font-size: 12px; color: var(--status-danger); font-weight: 600;">
                    ⚠️ Prioritas tinggi / kritis
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 13px; font-weight: 600;">
                    <span>Perlu Restok</span>
                    <i class="bi bi-clock-history fs-4" style="color: var(--status-warning);"></i>
                </div>
                <div class="stat-number" style="color: #b45309;">{{ $perluRestokCount }}</div>
                <div class="mt-2" style="font-size: 12px; color: #b45309; font-weight: 600;">
                    ⏳ Dekati ambang batas aman
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card safe">
                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 13px; font-weight: 600;">
                    <span>Stok Masih Aman</span>
                    <i class="bi bi-shield-check fs-4" style="color: var(--status-safe);"></i>
                </div>
                <div class="stat-number" style="color: var(--status-safe);">{{ $stokAmanCount }}</div>
                <div class="mt-2" style="font-size: 12px; color: var(--status-safe); font-weight: 600;">
                    ✅ Persediaan tercukupi
                </div>
            </div>
        </div>
    </div>

    <!-- NAVIGATION TABS -->
    <ul class="nav nav-tabs nav-tabs-noir" id="fuzzyTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="monitoring-tab" data-bs-toggle="tab" data-bs-target="#monitoring-pane" type="button" role="tab">
                <i class="bi bi-table me-2"></i> 1. Monitoring Otomatis Seluruh Bahan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="calculator-tab" data-bs-toggle="tab" data-bs-target="#calculator-pane" type="button" role="tab">
                <i class="bi bi-calculator-fill me-2"></i> 2. Kalkulator Simulasi Fuzzy Mandiri
            </button>
        </li>
    </ul>

    <!-- TAB CONTENTS -->
    <div class="tab-content" id="fuzzyTabContent">

        <!-- ========================================== -->
        <!-- TAB 1: TABEL MONITORING OTOMATIS           -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="monitoring-pane" role="tabpanel">

            <!-- FILTER & SEARCH BAR -->
            <div class="noir-card p-3 mb-3">
                <form action="{{ route('admin.fuzzy-stok.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama bahan baku atau kategori..." value="{{ $search }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="kategori" class="form-select" onchange="this.form.submit()">
                            <option value="Semua">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat }}" {{ $kategoriFilter === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-brown w-100">
                            <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                        </button>
                    </div>
                    @if($search || ($kategoriFilter && $kategoriFilter !== 'Semua'))
                        <div class="col-12 col-md-2">
                            <a href="{{ route('admin.fuzzy-stok.index') }}" class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- TABLE MONITORING -->
            <div class="noir-card p-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-fuzzy m-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan Baku</th>
                                <th>Kategori</th>
                                <th style="width: 200px;">Stok Tersedia</th>
                                <th>Konsumsi / Hari</th>
                                <th>Status Fuzzy</th>
                                <th>Skor Kelayakan</th>
                                <th>Saran Restok</th>
                                <th>Estimasi Biaya</th>
                                <th class="text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanBakus as $index => $bahan)
                                @php
                                    $pct = $bahan->kapasitas_maksimal > 0 ? round(($bahan->stok / $bahan->kapasitas_maksimal) * 100, 1) : 0;
                                    $barColor = $bahan->fuzzy['warna'];
                                    $estimasiBiaya = ($bahan->fuzzy['saran_restok'] > 0 && $bahan->harga_satuan > 0)
                                        ? ($bahan->fuzzy['saran_restok'] * $bahan->harga_satuan)
                                        : 0;
                                @endphp
                                <tr>
                                    <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold" style="color: var(--noir-dark); font-size: 14px;">
                                            {{ $bahan->nama_bahan }}
                                        </div>
                                        <small class="text-muted">
                                            Lead time supplier: {{ $bahan->lead_time_hari }} hari | Min: {{ $bahan->stok_minimum }} {{ $bahan->satuan }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-light text-dark border px-3 py-1">
                                            {{ $bahan->kategori }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold fs-6" style="color: {{ $barColor }};">
                                                {{ $bahan->stok }} <small class="text-muted">{{ $bahan->satuan }}</small>
                                            </span>
                                            <small class="text-muted">{{ $pct }}% dari {{ $bahan->kapasitas_maksimal }}</small>
                                        </div>
                                        <div class="stock-progress">
                                            <div class="bar" style="width: {{ min(100, $pct) }}%; background-color: {{ $barColor }};"></div>
                                        </div>
                                        <small class="text-muted" style="font-size: 11px;">
                                            Ketahanan: ~{{ $bahan->fuzzy['hari_ketahanan'] }} hari
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $bahan->rata_rata_harian }} {{ $bahan->satuan }}</div>
                                        <small class="text-muted">Kebutuhan lead time: ~{{ $bahan->fuzzy['kebutuhan_lead_time'] }}</small>
                                    </td>
                                    <td>
                                        <span class="badge-fuzzy {{ $bahan->fuzzy['badge_class'] }}">
                                            @if($bahan->fuzzy['status'] === 'Restok Segera')
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                            @elseif($bahan->fuzzy['status'] === 'Perlu Restok')
                                                <i class="bi bi-clock-fill"></i>
                                            @else
                                                <i class="bi bi-check-circle-fill"></i>
                                            @endif
                                            {{ $bahan->fuzzy['status'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="fw-bold fs-6" style="color: {{ $bahan->fuzzy['warna'] }};">
                                                {{ $bahan->fuzzy['skor'] }}
                                            </div>
                                            <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $bahan->fuzzy['skor'] }}%; background-color: {{ $bahan->fuzzy['warna'] }};"></div>
                                            </div>
                                        </div>
                                        <small class="text-muted" style="font-size: 11px;">Skala 0 - 100</small>
                                    </td>
                                    <td>
                                        @if($bahan->fuzzy['saran_restok'] > 0)
                                            <span class="fw-bold" style="color: var(--status-danger); font-size: 14px;">
                                                +{{ $bahan->fuzzy['saran_restok'] }} {{ $bahan->satuan }}
                                            </span>
                                        @else
                                            <span class="text-muted fw-semibold">— Aman —</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($estimasiBiaya > 0)
                                            <span class="text-dark fw-semibold" style="font-size: 13px;">
                                                Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-action-restock" data-bs-toggle="modal" data-bs-target="#modalRestok{{ $bahan->id }}" title="Restok Cepat">
                                                <i class="bi bi-lightning-charge-fill me-1"></i> Restok
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $bahan->id }}" title="Edit Data">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.fuzzy-stok.destroy', $bahan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan baku {{ $bahan->nama_bahan }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-3" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL RESTOK CEPAT -->
                                <div class="modal fade" id="modalRestok{{ $bahan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="{{ route('admin.fuzzy-stok.restock', $bahan->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom-0 pb-0">
                                                    <h5 class="modal-title fw-bold" style="color: var(--noir-dark);">
                                                        ⚡ Aksi Cepat Restok Bahan Baku
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <div class="p-3 rounded-3 mb-3" style="background: var(--noir-cream-soft); border: 1px solid #ebdcd0;">
                                                        <div class="fw-bold fs-6">{{ $bahan->nama_bahan }}</div>
                                                        <div class="small text-muted">Kategori: {{ $bahan->kategori }} | Satuan: {{ $bahan->satuan }}</div>
                                                        <hr class="my-2">
                                                        <div class="d-flex justify-content-between small">
                                                            <span>Stok Saat Ini: <strong>{{ $bahan->stok }} {{ $bahan->satuan }}</strong></span>
                                                            <span>Saran Fuzzy: <strong class="text-danger">+{{ $bahan->fuzzy['saran_restok'] }} {{ $bahan->satuan }}</strong></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Jumlah Restok yang Masuk ({{ $bahan->satuan }}):</label>
                                                        <input type="number" step="0.1" min="0.1" name="jumlah_tambah" class="form-control form-control-lg rounded-3 fw-bold" value="{{ $bahan->fuzzy['saran_restok'] > 0 ? $bahan->fuzzy['saran_restok'] : 5 }}" required>
                                                        <small class="text-muted">Nilai otomatis terisi dengan rekomendasi cerdas Fuzzy Logic.</small>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label text-muted small">Catatan Pengadaan / No. Faktur (Opsional):</label>
                                                        <input type="text" name="keterangan_restok" class="form-control rounded-3" placeholder="Contoh: Pembelian supplier Gayo batch #22">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 pt-0">
                                                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-brown rounded-3 px-4">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Penambahan Stok
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL EDIT BAHAN BAKU -->
                                <div class="modal fade" id="modalEdit{{ $bahan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="{{ route('admin.fuzzy-stok.update', $bahan->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-bottom pb-3">
                                                    <h5 class="modal-title fw-bold" style="color: var(--noir-dark);">
                                                        ✏️ Edit Parameter Bahan Baku: {{ $bahan->nama_bahan }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Nama Bahan Baku</label>
                                                            <input type="text" name="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Kategori</label>
                                                            <input type="text" name="kategori" class="form-control" value="{{ $bahan->kategori }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stok Saat Ini</label>
                                                            <input type="number" step="0.1" min="0" name="stok" class="form-control" value="{{ $bahan->stok }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Satuan Unit</label>
                                                            <input type="text" name="satuan" class="form-control" value="{{ $bahan->satuan }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Konsumsi Rata-rata / Hari</label>
                                                            <input type="number" step="0.1" min="0" name="rata_rata_harian" class="form-control" value="{{ $bahan->rata_rata_harian }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stok Minimum (Safety)</label>
                                                            <input type="number" step="0.1" min="0" name="stok_minimum" class="form-control" value="{{ $bahan->stok_minimum }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Kapasitas Maksimal</label>
                                                            <input type="number" step="0.1" min="0.1" name="kapasitas_maksimal" class="form-control" value="{{ $bahan->kapasitas_maksimal }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lead Time (Hari)</label>
                                                            <input type="number" min="1" name="lead_time_hari" class="form-control" value="{{ $bahan->lead_time_hari }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Harga Satuan (Rp)</label>
                                                            <input type="number" min="0" name="harga_satuan" class="form-control" value="{{ $bahan->harga_satuan }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Keterangan / Catatan</label>
                                                            <input type="text" name="keterangan" class="form-control" value="{{ $bahan->keterangan }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top pt-3">
                                                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-brown rounded-3 px-4">
                                                        <i class="bi bi-save me-1"></i> Perbarui Data Bahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada data bahan baku yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- RANGKUMAN PENJELASAN ATURAN -->
            <div class="noir-card mt-4">
                <h5 class="fw-bold mb-3" style="color: var(--noir-dark);">
                    📚 Panduan Indikator Warna Status Fuzzy
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-4" style="background: #fdf2f2; border: 1px solid #f5c2c7;">
                            <span class="badge-fuzzy badge-danger-fuzzy mb-2">Restok Segera (Skor 70 - 100)</span>
                            <div class="small text-muted">
                                Persediaan bahan sangat rendah atau laju penjualan sedang melonjak tinggi. Pembelian bahan ke supplier harus diproses hari ini juga untuk menghindari kehabisan stok (stock-out).
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4" style="background: #fef9e7; border: 1px solid #fde68a;">
                            <span class="badge-fuzzy badge-warning-fuzzy mb-2">Perlu Restok (Skor 40 - 69)</span>
                            <div class="small text-muted">
                                Persediaan masih dapat mendukung produksi 2-4 hari ke depan namun telah menyentuh batas pemesanan ulang (Reorder Point). Segera jadwalkan PO supplier.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <span class="badge-fuzzy badge-success-fuzzy mb-2">Stok Masih Aman (Skor 0 - 39)</span>
                            <div class="small text-muted">
                                Ketersediaan bahan di gudang kafe mencukupi dengan rasio konsumsi stabil. Tidak perlu melakukan order tambahan saat ini guna menghindari overstock & expired.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB 2: KALKULATOR SIMULASI FUZZY MANDIRI   -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="calculator-pane" role="tabpanel">

            <div class="row g-4">
                <!-- FORM INPUT SIMULASI -->
                <div class="col-lg-5">
                    <div class="noir-card h-100">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge rounded-circle p-2" style="background: var(--noir-gold); color: #140f05;">
                                <i class="bi bi-sliders fs-5"></i>
                            </span>
                            <div>
                                <h5 class="fw-bold m-0" style="color: var(--noir-dark);">Parameter Uji Simulasi</h5>
                                <small class="text-muted">Masukkan data stok untuk menguji rekomendasi Fuzzy Logic</small>
                            </div>
                        </div>

                        <form id="formSimulasiFuzzy">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Nama Bahan Baku (Opsional):</label>
                                <input type="text" id="sim_nama_bahan" name="nama_bahan" class="form-control rounded-3" placeholder="Contoh: Biji Kopi Arabika" value="Simulasi Bahan Baku Kopi">
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-7">
                                    <label class="form-label fw-bold small text-muted">Jumlah Stok Tersedia Saat Ini:</label>
                                    <input type="number" step="0.1" min="0" id="sim_stok" name="stok" class="form-control form-control-lg rounded-3 fw-bold" value="8.5" required>
                                </div>
                                <div class="col-5">
                                    <label class="form-label fw-bold small text-muted">Satuan Unit:</label>
                                    <input type="text" id="sim_satuan" name="satuan" class="form-control form-control-lg rounded-3" value="kg" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Rata-rata Konsumsi / Permintaan Harian:</label>
                                <input type="number" step="0.1" min="0.01" id="sim_rata_rata" name="rata_rata_harian" class="form-control rounded-3" value="3.5" required>
                                <small class="text-muted" style="font-size: 11px;">Berdasarkan riwayat transaksi penjualan kafe per hari.</small>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold small text-muted">Kapasitas Maksimal Gudang:</label>
                                    <input type="number" step="0.1" min="1" id="sim_kapasitas" name="kapasitas_maksimal" class="form-control rounded-3" value="40" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold small text-muted">Lead Time Supplier (Hari):</label>
                                    <input type="number" min="1" id="sim_lead_time" name="lead_time_hari" class="form-control rounded-3" value="2" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 pt-2">
                                <button type="button" class="btn btn-gold btn-lg shadow-sm" onclick="jalankanSimulasi()">
                                    <i class="bi bi-cpu-fill me-1"></i> Hitung Rekomendasi Fuzzy
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" onclick="resetSimulasi()">
                                    Reset Parameter Contoh
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- PANEL HASIL SIMULASI FUZZY -->
                <div class="col-lg-7">
                    <div class="noir-card h-100" id="panelHasilSimulasi">

                        <!-- RESULT HEADER -->
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <h5 class="fw-bold m-0" id="res_nama_bahan" style="color: var(--noir-dark);">
                                    Hasil Analisis Rekomendasi
                                </h5>
                                <small class="text-muted" id="res_sub_info">Metode Tsukamoto / Mamdani Weighted Average</small>
                            </div>
                            <span class="badge-fuzzy" id="res_badge_status">
                                <!-- Status badge filled via JS -->
                            </span>
                        </div>

                        <!-- SCORE & RECOMMENDATION HIGHLIGHT -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 text-center" style="background: var(--noir-cream-soft); border: 1px solid #ebdcd0;">
                                    <div class="small text-muted fw-bold text-uppercase">Nilai Derajat Kelayakan (Z*)</div>
                                    <div class="display-5 fw-bold my-1" id="res_skor_angka" style="color: var(--noir-dark);">—</div>
                                    <div class="small fw-semibold" id="res_skor_label">Skala 0 (Aman) - 100 (Sangat Kritis)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-4 text-center" style="background: #fdf2f2; border: 1px solid #f5c2c7;" id="res_box_rekomendasi">
                                    <div class="small text-muted fw-bold text-uppercase">Saran Kuantitas Order</div>
                                    <div class="display-5 fw-bold my-1 text-danger" id="res_saran_restok">—</div>
                                    <div class="small text-muted" id="res_ketahanan_hari">Ketahanan stok: ~ hari</div>
                                </div>
                            </div>
                        </div>

                        <!-- EXPLANATION ALERT -->
                        <div class="alert rounded-3 mb-4" id="res_alert_box" style="background: #f9f9f9; border-left: 4px solid var(--noir-gold);">
                            <div class="fw-bold" id="res_prioritas_title">Aksi Rekomendasi:</div>
                            <div class="small text-muted" id="res_keterangan_aksi">
                                Klik tombol "Hitung Rekomendasi Fuzzy" untuk melihat hasil inferensi.
                            </div>
                        </div>

                        <!-- STEP 1: FUZZIFIKASI DETAILS -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2" style="color: var(--noir-dark);">
                                1. Derajat Keanggotaan Fuzzifikasi (μ):
                            </h6>
                            <div class="row g-3 small">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border">
                                        <div class="fw-bold mb-1">📦 Variabel Stok Tersedia (<span id="res_stok_pct">0</span>%)</div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Rendah (μ_R):</span>
                                            <strong id="mu_stok_rendah">0.00</strong>
                                        </div>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div id="bar_stok_rendah" class="progress-bar bg-danger" style="width: 0%"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Sedang (μ_S):</span>
                                            <strong id="mu_stok_sedang">0.00</strong>
                                        </div>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div id="bar_stok_sedang" class="progress-bar bg-warning" style="width: 0%"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Tinggi (μ_T):</span>
                                            <strong id="mu_stok_tinggi">0.00</strong>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div id="bar_stok_tinggi" class="progress-bar bg-success" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border">
                                        <div class="fw-bold mb-1">📈 Variabel Laju Permintaan (<span id="res_permintaan_pct">0</span>%)</div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Rendah (μ_R):</span>
                                            <strong id="mu_permintaan_rendah">0.00</strong>
                                        </div>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div id="bar_permintaan_rendah" class="progress-bar bg-success" style="width: 0%"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Sedang (μ_S):</span>
                                            <strong id="mu_permintaan_sedang">0.00</strong>
                                        </div>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div id="bar_permintaan_sedang" class="progress-bar bg-warning" style="width: 0%"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Tinggi (μ_T):</span>
                                            <strong id="mu_permintaan_tinggi">0.00</strong>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div id="bar_permintaan_tinggi" class="progress-bar bg-danger" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: ACTIVE RULES & DEFUZZIFICATION -->
                        <div>
                            <h6 class="fw-bold mb-2" style="color: var(--noir-dark);">
                                2. Aturan Fuzzy yang Aktif (Fire Strength α-Predikat):
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered m-0 small" style="background: white;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Aturan</th>
                                            <th>Kombinasi Kondisi</th>
                                            <th>Fire Strength (α)</th>
                                            <th>Konsekuen</th>
                                            <th>Nilai z</th>
                                            <th>α × z</th>
                                        </tr>
                                    </thead>
                                    <tbody id="res_tabel_aturan_aktif">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada perhitungan</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 p-2 bg-light rounded text-muted small text-end" id="res_rumus_defuzzifikasi">
                                Defuzzifikasi: Z* = Σ(α × z) / Σα
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- MODAL TAMBAH BAHAN BAKU BARU -->
<div class="modal fade" id="modalTambahBahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('admin.fuzzy-stok.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom pb-3">
                    <h5 class="modal-title fw-bold" style="color: var(--noir-dark);">
                        ➕ Tambah Bahan Baku Baru ke Inventaris
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Bahan Baku</label>
                            <input type="text" name="nama_bahan" class="form-control" placeholder="Contoh: Biji Kopi Flores Bajawa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori Bahan</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Biji Kopi, Dairy, Sirup, Powder" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stok Awal</label>
                            <input type="number" step="0.1" min="0" name="stok" class="form-control" value="10" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Satuan Unit</label>
                            <input type="text" name="satuan" class="form-control" placeholder="kg / liter / pcs / botol" value="kg" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Konsumsi Rata-rata / Hari</label>
                            <input type="number" step="0.1" min="0" name="rata_rata_harian" class="form-control" value="2" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stok Minimum (Batas Bahaya)</label>
                            <input type="number" step="0.1" min="0" name="stok_minimum" class="form-control" value="5" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kapasitas Maksimal Gudang</label>
                            <input type="number" step="0.1" min="0.1" name="kapasitas_maksimal" class="form-control" value="50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Lead Time Supplier (Hari)</label>
                            <input type="number" min="1" name="lead_time_hari" class="form-control" value="2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga Satuan Pengadaan (Rp)</label>
                            <input type="number" min="0" name="harga_satuan" class="form-control" placeholder="120000" value="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Keterangan / Supplier</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Nama supplier atau catatan rasa">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold rounded-3 px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan ke Inventaris
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Responsive sidebar drawer toggle
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Client-side instant Fuzzy Calculator Engine (Tsukamoto / Mamdani)
    function hitungFuzzyClientSide(stok, permintaan, kapasitas, leadTime, stokMinimum) {
        stok = Math.max(0, parseFloat(stok) || 0);
        permintaan = Math.max(0.01, parseFloat(permintaan) || 0.01);
        kapasitas = Math.max(1, parseFloat(kapasitas) || 1);
        leadTime = Math.max(1, parseInt(leadTime) || 1);
        stokMinimum = Math.max(0.1, parseFloat(stokMinimum) || 0.1);

        // 1. Fuzzifikasi Stok
        const stokPct = (stok / kapasitas) * 100.0;
        let muStokRendah = 0;
        let muStokSedang = 0;
        let muStokTinggi = 0;

        if (stokPct <= 25.0) {
            muStokRendah = 1.0;
        } else if (stokPct > 25.0 && stokPct < 50.0) {
            muStokRendah = (50.0 - stokPct) / 25.0;
        }

        if (stokPct > 25.0 && stokPct <= 50.0) {
            muStokSedang = (stokPct - 25.0) / 25.0;
        } else if (stokPct > 50.0 && stokPct < 75.0) {
            muStokSedang = (75.0 - stokPct) / 25.0;
        }

        if (stokPct > 50.0 && stokPct < 75.0) {
            muStokTinggi = (stokPct - 50.0) / 25.0;
        } else if (stokPct >= 75.0) {
            muStokTinggi = 1.0;
        }

        // 2. Fuzzifikasi Permintaan
        const permintaanNormalHarian = Math.max(0.5, kapasitas / 14.0);
        const permintaanPct = (permintaan / permintaanNormalHarian) * 100.0;
        let muPermintaanRendah = 0;
        let muPermintaanSedang = 0;
        let muPermintaanTinggi = 0;

        if (permintaanPct <= 50.0) {
            muPermintaanRendah = 1.0;
        } else if (permintaanPct > 50.0 && permintaanPct < 85.0) {
            muPermintaanRendah = (85.0 - permintaanPct) / 35.0;
        }

        if (permintaanPct > 50.0 && permintaanPct <= 100.0) {
            muPermintaanSedang = (permintaanPct - 50.0) / 50.0;
        } else if (permintaanPct > 100.0 && permintaanPct < 140.0) {
            muPermintaanSedang = (140.0 - permintaanPct) / 40.0;
        }

        if (permintaanPct > 100.0 && permintaanPct < 140.0) {
            muPermintaanTinggi = (permintaanPct - 100.0) / 40.0;
        } else if (permintaanPct >= 140.0) {
            muPermintaanTinggi = 1.0;
        }

        // 3. Evaluasi Basis Aturan (Tsukamoto / Mamdani)
        const rules = [
            { code: 'R1', cond: 'Stok Rendah & Permintaan Rendah', alpha: Math.min(muStokRendah, muPermintaanRendah), cons: 'Perlu Restok', z: 60.0 },
            { code: 'R2', cond: 'Stok Rendah & Permintaan Sedang', alpha: Math.min(muStokRendah, muPermintaanSedang), cons: 'Restok Segera', z: 88.0 },
            { code: 'R3', cond: 'Stok Rendah & Permintaan Tinggi', alpha: Math.min(muStokRendah, muPermintaanTinggi), cons: 'Restok Segera', z: 100.0 },
            { code: 'R4', cond: 'Stok Sedang & Permintaan Rendah', alpha: Math.min(muStokSedang, muPermintaanRendah), cons: 'Stok Masih Aman', z: 25.0 },
            { code: 'R5', cond: 'Stok Sedang & Permintaan Sedang', alpha: Math.min(muStokSedang, muPermintaanSedang), cons: 'Perlu Restok', z: 55.0 },
            { code: 'R6', cond: 'Stok Sedang & Permintaan Tinggi', alpha: Math.min(muStokSedang, muPermintaanTinggi), cons: 'Restok Segera', z: 80.0 },
            { code: 'R7', cond: 'Stok Tinggi & Permintaan Rendah', alpha: Math.min(muStokTinggi, muPermintaanRendah), cons: 'Stok Masih Aman', z: 10.0 },
            { code: 'R8', cond: 'Stok Tinggi & Permintaan Sedang', alpha: Math.min(muStokTinggi, muPermintaanSedang), cons: 'Stok Masih Aman', z: 30.0 },
            { code: 'R9', cond: 'Stok Tinggi & Permintaan Tinggi', alpha: Math.min(muStokTinggi, muPermintaanTinggi), cons: 'Perlu Restok', z: 50.0 },
        ];

        let num = 0;
        let den = 0;
        const activeRules = [];

        rules.forEach(r => {
            if (r.alpha > 0.001) {
                num += (r.alpha * r.z);
                den += r.alpha;
                activeRules.push(r);
            }
        });

        let crisp = den > 0 ? (num / den) : 50.0;
        crisp = Math.min(100, Math.max(0, crisp));

        // Status & Warna
        let status = 'Stok Masih Aman';
        let warna = '#4E7852';
        let badgeClass = 'badge-success-fuzzy';
        let prioritas = 'Rendah (Aman)';
        let ketAksi = 'Persediaan bahan baku sangat mencukupi untuk operasional kafe saat ini.';

        if (crisp >= 70.0) {
            status = 'Restok Segera';
            warna = '#B94A48';
            badgeClass = 'badge-danger-fuzzy';
            prioritas = 'Tinggi (Kritis)';
            ketAksi = 'Stok berada di bawah ambang batas aman atau permintaan tinggi. Segera pesan bahan ke supplier.';
        } else if (crisp >= 40.0) {
            status = 'Perlu Restok';
            warna = '#D99B26';
            badgeClass = 'badge-warning-fuzzy';
            prioritas = 'Sedang (Peringatan)';
            ketAksi = 'Stok mencukupi untuk beberapa hari ke depan, namun telah menyentuh batas pemesanan ulang (Reorder Point).';
        }

        const kebutuhanLeadTime = permintaan * leadTime;
        const kekurangan = Math.max(0, kapasitas - stok + kebutuhanLeadTime);
        let saranRestok = 0;
        if (crisp >= 40.0) {
            saranRestok = Math.max(0, Math.round(kekurangan * Math.max(0.6, crisp / 100.0) * 10) / 10);
            if (saranRestok < 1 && kapasitas > 5) saranRestok = 1;
        }

        const hariKetahanan = permintaan > 0 ? (Math.round((stok / permintaan) * 10) / 10) : 999;

        return {
            skor: Math.round(crisp * 100) / 100,
            status,
            warna,
            badgeClass,
            prioritas,
            ketAksi,
            saranRestok,
            hariKetahanan,
            stokPct: Math.round(stokPct * 10) / 10,
            permintaanPct: Math.round(permintaanPct * 10) / 10,
            mu: {
                stokRendah: Math.round(muStokRendah * 1000) / 1000,
                stokSedang: Math.round(muStokSedang * 1000) / 1000,
                stokTinggi: Math.round(muStokTinggi * 1000) / 1000,
                permintaanRendah: Math.round(muPermintaanRendah * 1000) / 1000,
                permintaanSedang: Math.round(muPermintaanSedang * 1000) / 1000,
                permintaanTinggi: Math.round(muPermintaanTinggi * 1000) / 1000,
            },
            activeRules,
            num: Math.round(num * 100) / 100,
            den: Math.round(den * 1000) / 1000,
        };
    }

    function jalankanSimulasi() {
        const nama = document.getElementById('sim_nama_bahan').value || 'Simulasi Bahan Baku';
        const stok = document.getElementById('sim_stok').value;
        const satuan = document.getElementById('sim_satuan').value || 'unit';
        const permintaan = document.getElementById('sim_rata_rata').value;
        const kapasitas = document.getElementById('sim_kapasitas').value;
        const leadTime = document.getElementById('sim_lead_time').value;

        const res = hitungFuzzyClientSide(stok, permintaan, kapasitas, leadTime, 5);

        // Update UI
        document.getElementById('res_nama_bahan').innerText = nama;
        document.getElementById('res_sub_info').innerText = `Stok: ${stok} ${satuan} | Permintaan: ${permintaan} ${satuan}/hari | Kapasitas: ${kapasitas} ${satuan}`;

        const badgeEl = document.getElementById('res_badge_status');
        badgeEl.className = `badge-fuzzy ${res.badgeClass}`;
        badgeEl.innerHTML = `<i class="bi bi-circle-fill"></i> ${res.status}`;

        const skorEl = document.getElementById('res_skor_angka');
        skorEl.innerText = res.skor;
        skorEl.style.color = res.warna;

        const saranEl = document.getElementById('res_saran_restok');
        saranEl.innerText = res.saranRestok > 0 ? `+${res.saranRestok} ${satuan}` : '— Tidak Perlu —';
        saranEl.style.color = res.warna;

        document.getElementById('res_ketahanan_hari').innerText = `Ketahanan stok saat ini: ~${res.hariKetahanan} hari`;

        const alertBox = document.getElementById('res_alert_box');
        alertBox.style.borderLeftColor = res.warna;
        document.getElementById('res_prioritas_title').innerText = `Prioritas ${res.prioritas}:`;
        document.getElementById('res_keterangan_aksi').innerText = res.ketAksi;

        // Fuzzifikasi Progress & Numbers
        document.getElementById('res_stok_pct').innerText = res.stokPct;
        document.getElementById('mu_stok_rendah').innerText = res.mu.stokRendah;
        document.getElementById('bar_stok_rendah').style.width = `${res.mu.stokRendah * 100}%`;
        document.getElementById('mu_stok_sedang').innerText = res.mu.stokSedang;
        document.getElementById('bar_stok_sedang').style.width = `${res.mu.stokSedang * 100}%`;
        document.getElementById('mu_stok_tinggi').innerText = res.mu.stokTinggi;
        document.getElementById('bar_stok_tinggi').style.width = `${res.mu.stokTinggi * 100}%`;

        document.getElementById('res_permintaan_pct').innerText = res.permintaanPct;
        document.getElementById('mu_permintaan_rendah').innerText = res.mu.permintaanRendah;
        document.getElementById('bar_permintaan_rendah').style.width = `${res.mu.permintaanRendah * 100}%`;
        document.getElementById('mu_permintaan_sedang').innerText = res.mu.permintaanSedang;
        document.getElementById('bar_permintaan_sedang').style.width = `${res.mu.permintaanSedang * 100}%`;
        document.getElementById('mu_permintaan_tinggi').innerText = res.mu.permintaanTinggi;
        document.getElementById('bar_permintaan_tinggi').style.width = `${res.mu.permintaanTinggi * 100}%`;

        // Active Rules Table
        const tbody = document.getElementById('res_tabel_aturan_aktif');
        tbody.innerHTML = '';
        if (res.activeRules.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Tidak ada aturan yang aktif</td></tr>';
        } else {
            res.activeRules.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="fw-bold">${r.code}</td>
                    <td>${r.cond}</td>
                    <td class="fw-bold text-primary">${Math.round(r.alpha * 1000) / 1000}</td>
                    <td><span class="badge bg-light text-dark border">${r.cons}</span></td>
                    <td>${r.z}</td>
                    <td class="fw-bold">${Math.round(r.alpha * r.z * 100) / 100}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('res_rumus_defuzzifikasi').innerHTML = `
            <strong>Perhitungan Defuzzifikasi Tsukamoto:</strong><br>
            Z* = Σ(α × z) / Σα = <strong>${res.num} / ${res.den} = ${res.skor}</strong>
        `;
    }

    function resetSimulasi() {
        document.getElementById('sim_nama_bahan').value = 'Biji Kopi Arabika House Blend';
        document.getElementById('sim_stok').value = '6.5';
        document.getElementById('sim_satuan').value = 'kg';
        document.getElementById('sim_rata_rata').value = '4.0';
        document.getElementById('sim_kapasitas').value = '40.0';
        document.getElementById('sim_lead_time').value = '2';
        jalankanSimulasi();
    }

    // Run initial simulation on load
    document.addEventListener('DOMContentLoaded', function () {
        jalankanSimulasi();
    });
</script>

</body>
</html>
