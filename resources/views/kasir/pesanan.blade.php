<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Pesanan Kasir — NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #c89b3c;
            --gold-light: #e5c378;
            --dark-base: #140f05;
            --dark-surface: #1b1407;
            --dark-card: #221a0c;
            --dark-border: rgba(200, 155, 60, 0.22);
            --green: #22c55e;
            --green-hover: #16a34a;
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

        .order-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 20px;
            transition: all 0.25s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .order-card:hover {
            border-color: var(--gold);
            transform: translateY(-3px);
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-menunggu { background: #f59e0b; color: #140f05; }
        .status-diproses { background: #3b82f6; color: #ffffff; }
        .status-selesai { background: #22c55e; color: #ffffff; }

        .payment-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 10px;
        }
        .pay-lunas { background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #86efac; }
        .pay-belum { background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; }

        .item-row {
            background: var(--dark-card);
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .menu-thumb {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid rgba(200, 155, 60, 0.3);
        }

        .filter-tab {
            background: #2a2012;
            color: #e5dec2;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-tab:hover, .filter-tab.active {
            background: var(--gold);
            color: #140f05;
            border-color: var(--gold);
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
                <span class="text-muted ms-1 fs-6">| ANTREAN PESANAN</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('kasir.index') }}" class="btn-pos-nav">
                <i class="bi bi-calculator"></i> Kasir POS
            </a>
            <a href="{{ route('kasir.pesanan') }}" class="btn-pos-nav active">
                <i class="bi bi-clock-history"></i> Antrean Pesanan
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
        </div>
    </nav>

    <div class="container py-2" style="max-width: 1100px;">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold text-white m-0">📋 Daftar & Antrean Pesanan</h2>
                <p class="text-muted m-0">Kelola proses penyajian pesanan dan konfirmasi pembayaran pelanggan</p>
            </div>
            <div>
                <a href="{{ route('kasir.index') }}" class="btn btn-warning fw-bold rounded-3 px-4 py-2" style="background:var(--gold); border:none; color:#140f05;">
                    <i class="bi bi-plus-circle-fill"></i> Transaksi Kasir Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" style="background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #86efac;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('kasir.pesanan') }}" class="filter-tab {{ !$status || $status === 'Semua' ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('kasir.pesanan', ['status' => 'Menunggu']) }}" class="filter-tab {{ $status === 'Menunggu' ? 'active' : '' }}">
                    ⏳ Menunggu
                </a>
                <a href="{{ route('kasir.pesanan', ['status' => 'Diproses']) }}" class="filter-tab {{ $status === 'Diproses' ? 'active' : '' }}">
                    🔥 Diproses
                </a>
                <a href="{{ route('kasir.pesanan', ['status' => 'Selesai']) }}" class="filter-tab {{ $status === 'Selesai' ? 'active' : '' }}">
                    ✓ Selesai
                </a>
            </div>

            <form action="{{ route('kasir.pesanan') }}" method="GET" class="d-flex gap-2">
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <input type="text" name="search" class="form-control" style="background:#2a2012; border:1px solid rgba(200,155,60,0.3); color:white; border-radius:12px; width:220px;" placeholder="Cari kode/nama..." value="{{ $search }}">
                <button type="submit" class="btn btn-outline-light rounded-3 px-3"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <!-- Orders Queue List -->
        @forelse($pesanans as $kodePesanan => $items)
            @php
                $first = $items->first();
                $totalOrder = $items->sum('total_harga');
                $statusClass = match($first->status) {
                    'Menunggu' => 'status-menunggu',
                    'Diproses' => 'status-diproses',
                    'Selesai' => 'status-selesai',
                    default => 'status-menunggu',
                };
            @endphp
            <div class="order-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge" style="background:var(--gold); color:#140f05; font-size:14px; font-weight:700;">
                                #{{ $first->kode_pesanan }}
                            </span>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $first->status }}
                            </span>
                            <span class="payment-badge {{ $first->status_pembayaran === 'Sudah Dibayar' ? 'pay-lunas' : 'pay-belum' }}">
                                <i class="bi bi-credit-card me-1"></i> {{ $first->status_pembayaran }} ({{ $first->metode_pembayaran }})
                            </span>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-person-fill"></i> <strong>{{ $first->nama_pembeli }}</strong> &bull; 
                            <i class="bi bi-geo-alt-fill"></i> <strong>{{ $first->nomor_meja }}</strong> &bull; 
                            <i class="bi bi-clock"></i> {{ $first->created_at->format('d M Y, H:i') }} WIB
                        </div>
                    </div>

                    <div class="text-end">
                        <div class="small text-muted">Total Pembayaran</div>
                        <div class="fw-bold fs-4" style="color:var(--green);">
                            Rp {{ number_format($totalOrder, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Item List -->
                <div class="row g-2 mb-3">
                    @foreach($items as $item)
                        @php
                            $imgSrc = $item->menu && $item->menu->gambar && file_exists(public_path('images/' . $item->menu->gambar))
                                ? asset('images/' . $item->menu->gambar)
                                : asset('images/logo.jpg');
                        @endphp
                        <div class="col-md-6">
                            <div class="item-row d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $imgSrc }}" class="menu-thumb" alt="{{ $item->menu->nama_kopi ?? 'Menu' }}">
                                    <div>
                                        <div class="fw-bold text-white fs-6">{{ $item->menu->nama_kopi ?? 'Menu Kopi' }}</div>
                                        <small class="text-muted">{{ $item->jumlah }}x @ Rp {{ number_format($item->menu->harga ?? 0, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <div class="fw-bold text-warning">
                                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2 border-top border-secondary border-opacity-25">
                    <div>
                        <a href="{{ route('kasir.struk', $first->kode_pesanan) }}" target="_blank" class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold" style="border-color:var(--gold); color:var(--gold-light);">
                            <i class="bi bi-printer-fill me-1"></i> Cetak Struk POS
                        </a>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @if($first->status_pembayaran !== 'Sudah Dibayar')
                            <form action="{{ route('kasir.payment', $first->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                    <i class="bi bi-check2-circle"></i> Konfirmasi Lunas
                                </button>
                            </form>
                        @endif

                        @if($first->status === 'Menunggu')
                            <a href="{{ route('kasir.pesanan.status', $first->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                                <i class="bi bi-play-fill"></i> Mulai Proses
                            </a>
                        @elseif($first->status === 'Diproses')
                            <a href="{{ route('kasir.pesanan.status', $first->id) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                <i class="bi bi-check-lg"></i> Tandai Selesai
                            </a>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary-emphasis px-3 py-2 rounded-pill">
                                ✓ Pesanan Telah Selesai
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted order-card">
                <i class="bi bi-cup-hot fs-1 d-block mb-3" style="color:var(--gold);"></i>
                <h4 class="fw-bold text-white mb-2">Tidak Ada Pesanan</h4>
                <p class="text-muted">Belum ada pesanan pada filter antrean ini.</p>
            </div>
        @endforelse

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
