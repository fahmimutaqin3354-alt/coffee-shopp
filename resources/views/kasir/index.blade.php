<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS — NOIR COFFEE</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
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
            --green-hover: #16a34a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-base);
            color: #f8f3e7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Top Navbar */
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

        .role-badge {
            background: rgba(200, 155, 60, 0.18);
            color: var(--gold-light);
            border: 1px solid var(--gold);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Nav Pills / Buttons */
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

        /* Main Container */
        .pos-container {
            flex: 1;
            padding: 20px 24px;
        }

        /* Stats Bar */
        .stats-bar {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(200, 155, 60, 0.15);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Catalog Section (Left) */
        .catalog-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .search-input {
            background: #2a2012;
            border: 1px solid rgba(200, 155, 60, 0.3);
            color: #ffffff;
            border-radius: 14px;
            padding: 12px 18px;
            font-size: 15px;
        }

        .search-input:focus {
            background: #342818;
            border-color: var(--gold);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(200, 155, 60, 0.3);
        }

        .category-pill {
            background: #2a2012;
            color: #e5dec2;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .category-pill:hover, .category-pill.active {
            background: var(--gold);
            color: #140f05;
            border-color: var(--gold);
            box-shadow: 0 4px 12px rgba(200, 155, 60, 0.25);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
            gap: 16px;
            overflow-y: auto;
            max-height: calc(100vh - 280px);
            padding-right: 6px;
        }

        .menu-grid::-webkit-scrollbar, .cart-items-box::-webkit-scrollbar {
            width: 6px;
        }
        .menu-grid::-webkit-scrollbar-thumb, .cart-items-box::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 10px;
        }

        /* Menu Item Card (Same design as customer page) */
        .pos-menu-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 18px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            text-align: center;
            transition: all 0.25s ease;
            position: relative;
        }

        .pos-menu-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
            box-shadow: 0 10px 25px rgba(200, 155, 60, 0.2);
        }

        .pos-menu-img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            margin: 5px auto 10px auto;
            display: block;
            background: #2a2012;
            border: 2px solid rgba(200, 155, 60, 0.3);
            padding: 4px;
        }

        .badge-cat {
            background: #6f4e37;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .pos-menu-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .pos-menu-price {
            color: var(--green);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .btn-add-item {
            background: linear-gradient(135deg, #d4a745 0%, #b88628 100%);
            color: #140f05;
            font-weight: 700;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 12px;
            border: none;
            width: 100%;
            transition: all 0.2s;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-add-item:hover {
            background: var(--gold-hover);
            color: #ffffff;
            transform: scale(1.02);
        }

        /* Billing / Cart Section (Right) */
        .billing-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 22px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .billing-header {
            border-bottom: 1px solid var(--dark-border);
            padding-bottom: 14px;
            margin-bottom: 16px;
        }

        .cart-items-box {
            flex: 1;
            overflow-y: auto;
            max-height: 290px;
            margin-bottom: 16px;
            padding-right: 6px;
        }

        .cart-row {
            background: var(--dark-card);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .cart-row-title {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
            line-height: 1.2;
        }

        .cart-row-price {
            font-size: 13px;
            color: var(--gold-light);
            font-weight: 600;
        }

        .qty-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-qty {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid rgba(200, 155, 60, 0.3);
            background: #2a2012;
            color: #ffffff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-qty:hover {
            background: var(--gold);
            color: #140f05;
        }

        .qty-number {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            min-width: 22px;
            text-align: center;
        }

        .btn-del-item {
            color: #ef4444;
            background: transparent;
            border: none;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
        }

        .btn-del-item:hover {
            color: #f87171;
        }

        /* Order Info Form */
        .pos-field-label {
            font-size: 12px;
            font-weight: 600;
            color: #c5b8a5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .pos-input {
            background: #2a2012;
            border: 1px solid rgba(200, 155, 60, 0.3);
            color: #ffffff;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 14px;
        }

        .pos-input:focus {
            background: #342818;
            border-color: var(--gold);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(200, 155, 60, 0.3);
        }

        .payment-method-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .pay-method-btn {
            background: #2a2012;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5dec2;
            border-radius: 10px;
            padding: 8px 6px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pay-method-btn:hover, .pay-method-btn.selected {
            background: var(--gold);
            color: #140f05;
            border-color: var(--gold);
            font-weight: 700;
        }

        .quick-cash-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
            margin-top: 6px;
        }

        .btn-quick-cash {
            background: #2a2012;
            border: 1px solid rgba(200, 155, 60, 0.3);
            color: var(--gold-light);
            border-radius: 8px;
            padding: 4px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-quick-cash:hover {
            background: var(--gold);
            color: #140f05;
        }

        .grand-total-box {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 14px;
            margin: 12px 0;
        }

        .btn-checkout-pos {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 17px;
            padding: 14px;
            border-radius: 14px;
            border: none;
            width: 100%;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
        }

        .btn-checkout-pos:hover {
            background: var(--green-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.45);
        }

        .btn-checkout-pos:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Modal Struk / Sukses */
        .modal-content-noir {
            background: #1b1407;
            border: 1px solid var(--gold);
            border-radius: 24px;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar-kasir d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo.jpg') }}" alt="Noir Coffee Logo" class="logo-img">
            <div>
                <span class="fw-bold fs-5 tracking-wide text-white">NOIR <span style="color:var(--gold);">COFFEE</span></span>
                <span class="text-muted ms-1 fs-6">| KASIR POS</span>
            </div>
            <span class="role-badge ms-2">
                <i class="bi bi-person-badge-fill me-1"></i> {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
            </span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('kasir.index') }}" class="btn-pos-nav active">
                <i class="bi bi-calculator"></i> Kasir
            </a>
            <a href="{{ route('kasir.pesanan') }}" class="btn-pos-nav">
                <i class="bi bi-clock-history"></i> Antrean Pesanan
                @if($pesananAktifHariIni > 0)
                    <span class="badge bg-danger rounded-pill">{{ $pesananAktifHariIni }}</span>
                @endif
            </a>
            <a href="{{ route('kasir.laporan') }}" class="btn-pos-nav">
                <i class="bi bi-bar-chart-line"></i> Rekap Shift
            </a>

            <a href="{{ route('kasir.mood') }}" class="btn-pos-nav" style="background: rgba(200, 155, 60, 0.15); border-color: var(--gold); color: var(--gold-light);">
                <i class="bi bi-emoji-smile text-warning"></i> Deteksi Mood (CF)
            </a>

            @if(Auth::user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="btn-pos-nav" style="border-color: var(--gold); color: var(--gold);">
                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                </a>
            @endif

            <a href="{{ route('pelanggan.menu') }}" target="_blank" class="btn-pos-nav">
                <i class="bi bi-globe"></i> Web Menu
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-pos-nav" style="border-color: #ef4444; color: #f87171;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- POS CONTAINER -->
    <div class="pos-container">

        <!-- STATS BAR -->
        <div class="stats-bar">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-receipt"></i></div>
                        <div>
                            <div class="text-muted small">Transaksi Hari Ini</div>
                            <div class="fw-bold fs-5 text-white">{{ $totalTransaksiHariIni }} Pesanan</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-icon" style="color:var(--green);"><i class="bi bi-cash-stack"></i></div>
                        <div>
                            <div class="text-muted small">Pendapatan Hari Ini</div>
                            <div class="fw-bold fs-5" style="color:var(--green);">Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="stat-item">
                        <div class="stat-icon" style="color:#f59e0b;"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="text-muted small">Antrean Menunggu / Diproses</div>
                            <div class="fw-bold fs-5 text-warning">{{ $pesananAktifHariIni }} Pesanan Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success_pesanan'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-3" style="background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #86efac;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <strong>{{ session('success_pesanan') }}</strong>
                    </div>
                    @if(session('last_kode_pesanan'))
                        <a href="{{ route('kasir.struk', session('last_kode_pesanan')) }}" target="_blank" class="btn btn-sm btn-light fw-bold rounded-pill px-3">
                            <i class="bi bi-printer-fill"></i> Cetak Struk
                        </a>
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-3 border-0" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5;">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- DUAL COLUMN POS (MENU + BILLING) -->
        <div class="row g-3">

            <!-- LEFT: MENU CATALOG (ADJUSTS IN REALTIME WHEN ADMIN EDITS MENU) -->
            <div class="col-lg-8">
                <div class="catalog-card">

                    <!-- Search & Filter Controls -->
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <div class="flex-grow-1">
                            <input type="text" id="posSearch" class="form-control search-input" placeholder="🔍 Cari menu kopi atau makanan..." onkeyup="filterMenuCards()">
                        </div>
                    </div>

                    <!-- Category Pills -->
                    <div class="d-flex gap-2 overflow-x-auto pb-2 mb-3" id="categoryFilterBar">
                        <button type="button" class="category-pill active" onclick="filterCategory('Semua', this)">
                            ☕ Semua ({{ $menus->count() }})
                        </button>
                        <button type="button" class="category-pill" onclick="filterCategory('Coffee', this)">
                            Coffee
                        </button>
                        <button type="button" class="category-pill" onclick="filterCategory('Non Coffee', this)">
                            Non Coffee
                        </button>
                        <button type="button" class="category-pill" onclick="filterCategory('Makanan', this)">
                            Makanan
                        </button>
                        @foreach($kategoris as $kat)
                            @if(!in_array($kat, ['Coffee', 'Non Coffee', 'Makanan']))
                                <button type="button" class="category-pill" onclick="filterCategory('{{ $kat }}', this)">
                                    {{ $kat }}
                                </button>
                            @endif
                        @endforeach
                    </div>

                    <!-- Menu Grid Cards -->
                    <div class="menu-grid" id="posMenuGrid">
                        @forelse($menus as $menu)
                            @php
                                $imgSrc = $menu->gambar && file_exists(public_path('images/' . $menu->gambar))
                                    ? asset('images/' . $menu->gambar)
                                    : asset('images/logo.jpg');
                            @endphp
                            <div class="pos-menu-card menu-card-item"
                                 data-id="{{ $menu->id }}"
                                 data-nama="{{ strtolower($menu->nama_kopi) }}"
                                 data-kategori="{{ strtolower($menu->kategori) }}"
                                 data-jenis="{{ strtolower($menu->jenis_menu) }}">

                                <img src="{{ $imgSrc }}" 
                                     alt="{{ $menu->nama_kopi }}" 
                                     class="pos-menu-img"
                                     onerror="this.src='{{ asset('images/logo.jpg') }}'">

                                <span class="badge-cat">{{ $menu->kategori }}</span>

                                <h4 class="pos-menu-title">{{ $menu->nama_kopi }}</h4>

                                <div class="pos-menu-price">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </div>

                                <button type="button" class="btn-add-item" onclick="addToPosCart({{ $menu->id }}, '{{ addslashes($menu->nama_kopi) }}', {{ $menu->harga }}, '{{ $imgSrc }}')">
                                    <i class="bi bi-plus-circle-fill"></i> Tambah
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted col-12">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada menu kopi yang aktif di database.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            <!-- RIGHT: POS BILLING & CART PANEL -->
            <div class="col-lg-4">
                <div class="billing-card">

                    <div class="billing-header d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold m-0 text-white"><i class="bi bi-cart3 text-warning me-2"></i> Rincian Pesanan</h5>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0" onclick="clearPosCart()" title="Kosongkan Pesanan">
                            <i class="bi bi-trash"></i> Reset
                        </button>
                    </div>

                    <!-- Customer & Table Input -->
                    <form action="{{ route('kasir.store') }}" method="POST" id="posOrderForm">
                        @csrf

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="pos-field-label">Nama Pelanggan</label>
                                <input type="text" name="nama_pembeli" id="namaPembeli" class="form-control pos-input" placeholder="Walk-in" value="Pelanggan Walk-in">
                            </div>
                            <div class="col-6">
                                <label class="pos-field-label">No. Meja / Tipe</label>
                                <input type="text" name="nomor_meja" id="nomorMeja" class="form-control pos-input" placeholder="Take Away" value="Meja 1">
                            </div>
                        </div>

                        <!-- Cart Items Box -->
                        <div class="cart-items-box" id="posCartItemsList">
                            <div class="text-center py-4 text-muted" id="emptyCartNotice">
                                <i class="bi bi-bag-x fs-1 d-block mb-2"></i>
                                Keranjang masih kosong.<br>Klik menu di samping untuk menambahkan.
                            </div>
                        </div>

                        <!-- Totals & Payment Section -->
                        <div class="grand-total-box">
                            <div class="d-flex justify-content-between text-muted small mb-1">
                                <span>Total Item</span>
                                <span id="posTotalQty" class="fw-bold text-white">0 Item</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-white fs-6">Grand Total:</span>
                                <span class="fw-bold fs-4" style="color:var(--green);" id="posGrandTotalText">Rp 0</span>
                            </div>
                        </div>

                        <!-- Payment Method Selector -->
                        <div class="mb-2">
                            <label class="pos-field-label">Metode Pembayaran</label>
                            <input type="hidden" name="metode_pembayaran" id="selectedPaymentMethod" value="Cash">
                            <div class="payment-method-grid">
                                <div class="pay-method-btn selected" onclick="selectPayMethod('Cash', this)">
                                    <i class="bi bi-cash d-block fs-5"></i> Cash
                                </div>
                                <div class="pay-method-btn" onclick="selectPayMethod('QRIS', this)">
                                    <i class="bi bi-qr-code d-block fs-5"></i> QRIS
                                </div>
                                <div class="pay-method-btn" onclick="selectPayMethod('Debit', this)">
                                    <i class="bi bi-credit-card d-block fs-5"></i> Debit
                                </div>
                                <div class="pay-method-btn" onclick="selectPayMethod('Transfer', this)">
                                    <i class="bi bi-bank d-block fs-5"></i> Transfer
                                </div>
                            </div>
                        </div>

                        <!-- Cash Input & Change Calculator -->
                        <div class="mb-2" id="cashCalculatorSection">
                            <label class="pos-field-label">Uang Diterima (Rp)</label>
                            <input type="number" name="uang_diterima" id="uangDiterima" class="form-control pos-input" placeholder="Nominal uang tunai" min="0" oninput="calculateChange()">
                            
                            <div class="quick-cash-grid">
                                <button type="button" class="btn-quick-cash" onclick="setQuickCash('pas')">Uang Pas</button>
                                <button type="button" class="btn-quick-cash" onclick="setQuickCash(20000)">20.000</button>
                                <button type="button" class="btn-quick-cash" onclick="setQuickCash(50000)">50.000</button>
                                <button type="button" class="btn-quick-cash" onclick="setQuickCash(100000)">100.000</button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                <span class="small text-muted">Kembalian:</span>
                                <span class="fw-bold fs-6" style="color:var(--gold-light);" id="kembalianText">Rp 0</span>
                            </div>
                            <input type="hidden" name="kembalian" id="kembalianInput" value="0">
                        </div>

                        <!-- Payment Status -->
                        <div class="mb-3">
                            <label class="pos-field-label">Status Pembayaran</label>
                            <select name="status_pembayaran" id="statusPembayaran" class="form-select pos-input">
                                <option value="Sudah Dibayar" selected>✓ Sudah Dibayar (Lunas)</option>
                                <option value="Belum Dibayar">⏳ Belum Dibayar (Bayar Nanti)</option>
                            </select>
                        </div>

                        <!-- Hidden Inputs Container for Cart Items -->
                        <div id="hiddenItemsInputs"></div>

                        <!-- Checkout Button -->
                        <button type="submit" class="btn-checkout-pos" id="btnCheckout" disabled>
                            <i class="bi bi-printer-fill"></i>
                            <span>Bayar & Cetak Struk</span>
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // In-memory POS Cart
        let posCart = {}; // { menu_id: { id, nama, harga, qty, imgSrc } }

        function addToPosCart(id, nama, harga, imgSrc) {
            if (posCart[id]) {
                posCart[id].qty += 1;
            } else {
                posCart[id] = { id, nama, harga, qty: 1, imgSrc };
            }
            renderPosCart();
        }

        function updateQty(id, delta) {
            if (posCart[id]) {
                posCart[id].qty += delta;
                if (posCart[id].qty <= 0) {
                    delete posCart[id];
                }
            }
            renderPosCart();
        }

        function removeCartItem(id) {
            if (posCart[id]) {
                delete posCart[id];
            }
            renderPosCart();
        }

        function clearPosCart() {
            posCart = {};
            renderPosCart();
        }

        function renderPosCart() {
            const container = document.getElementById('posCartItemsList');
            const hiddenInputs = document.getElementById('hiddenItemsInputs');
            const emptyNotice = document.getElementById('emptyCartNotice');
            const btnCheckout = document.getElementById('btnCheckout');
            
            const itemKeys = Object.keys(posCart);

            if (itemKeys.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4 text-muted" id="emptyCartNotice">
                        <i class="bi bi-bag-x fs-1 d-block mb-2"></i>
                        Keranjang masih kosong.<br>Klik menu di samping untuk menambahkan.
                    </div>
                `;
                hiddenInputs.innerHTML = '';
                document.getElementById('posTotalQty').innerText = '0 Item';
                document.getElementById('posGrandTotalText').innerText = 'Rp 0';
                document.getElementById('kembalianText').innerText = 'Rp 0';
                btnCheckout.disabled = true;
                return;
            }

            let html = '';
            let hiddenHtml = '';
            let totalQty = 0;
            let grandTotal = 0;
            let index = 0;

            itemKeys.forEach(key => {
                const item = posCart[key];
                const subtotal = item.qty * item.harga;
                totalQty += item.qty;
                grandTotal += subtotal;

                html += `
                    <div class="cart-row">
                        <div class="flex-grow-1">
                            <h6 class="cart-row-title">${item.nama}</h6>
                            <span class="cart-row-price">Rp ${formatNumber(item.harga)}</span>
                        </div>
                        <div class="qty-controls">
                            <button type="button" class="btn-qty" onclick="updateQty(${item.id}, -1)">-</button>
                            <span class="qty-number">${item.qty}</span>
                            <button type="button" class="btn-qty" onclick="updateQty(${item.id}, 1)">+</button>
                            <button type="button" class="btn-del-item ms-1" onclick="removeCartItem(${item.id})">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                `;

                hiddenHtml += `
                    <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
                `;
                index++;
            });

            container.innerHTML = html;
            hiddenInputs.innerHTML = hiddenHtml;
            document.getElementById('posTotalQty').innerText = totalQty + ' Item';
            document.getElementById('posGrandTotalText').innerText = 'Rp ' + formatNumber(grandTotal);
            btnCheckout.disabled = false;

            calculateChange();
        }

        function calculateChange() {
            let grandTotal = 0;
            Object.values(posCart).forEach(item => {
                grandTotal += item.qty * item.harga;
            });

            const method = document.getElementById('selectedPaymentMethod').value;
            const cashInput = document.getElementById('uangDiterima');
            let received = parseFloat(cashInput.value) || 0;

            if (method !== 'Cash') {
                received = grandTotal;
                cashInput.value = grandTotal;
            }

            const change = Math.max(0, received - grandTotal);
            document.getElementById('kembalianText').innerText = 'Rp ' + formatNumber(change);
            document.getElementById('kembalianInput').value = change;
        }

        function setQuickCash(amount) {
            let grandTotal = 0;
            Object.values(posCart).forEach(item => {
                grandTotal += item.qty * item.harga;
            });

            if (amount === 'pas') {
                document.getElementById('uangDiterima').value = grandTotal;
            } else {
                document.getElementById('uangDiterima').value = amount;
            }
            calculateChange();
        }

        function selectPayMethod(method, btn) {
            document.getElementById('selectedPaymentMethod').value = method;
            document.querySelectorAll('.pay-method-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');

            const cashSection = document.getElementById('cashCalculatorSection');
            if (method === 'Cash') {
                document.getElementById('uangDiterima').removeAttribute('readonly');
            } else {
                setQuickCash('pas');
            }
        }

        function filterCategory(cat, btn) {
            document.querySelectorAll('.category-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const searchVal = document.getElementById('posSearch').value.toLowerCase().trim();
            const items = document.querySelectorAll('.menu-card-item');

            items.forEach(item => {
                const itemCat = item.dataset.kategori;
                const itemJenis = item.dataset.jenis;
                const itemNama = item.dataset.nama;

                const matchCat = (cat === 'Semua') 
                    || (cat.toLowerCase() === itemCat) 
                    || (cat.toLowerCase() === itemJenis);

                const matchSearch = (!searchVal) 
                    || itemNama.includes(searchVal) 
                    || itemCat.includes(searchVal);

                if (matchCat && matchSearch) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function filterMenuCards() {
            const activeCatBtn = document.querySelector('.category-pill.active');
            const cat = activeCatBtn ? activeCatBtn.innerText.replace(/☕|\(\d+\)/g, '').trim() : 'Semua';
            const searchVal = document.getElementById('posSearch').value.toLowerCase().trim();
            const items = document.querySelectorAll('.menu-card-item');

            items.forEach(item => {
                const itemCat = item.dataset.kategori;
                const itemJenis = item.dataset.jenis;
                const itemNama = item.dataset.nama;

                const matchCat = (cat === 'Semua') 
                    || (cat.toLowerCase() === itemCat) 
                    || (cat.toLowerCase() === itemJenis);

                const matchSearch = (!searchVal) 
                    || itemNama.includes(searchVal) 
                    || itemCat.includes(searchVal);

                if (matchCat && matchSearch) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    </script>
</body>
</html>
