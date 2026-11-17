<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Shift Kasir — NOIR COFFEE</title>

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

        .stat-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            text-align: center;
        }

        .stat-val {
            font-size: 32px;
            font-weight: 800;
            margin: 8px 0;
        }

        .recap-table-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .table-noir th {
            background: #2a2012;
            color: var(--gold-light);
            font-weight: 600;
            border-bottom: 1px solid var(--dark-border);
            padding: 16px;
        }

        .table-noir td {
            background: transparent;
            color: #f8f3e7;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px;
            vertical-align: middle;
        }

        @media print {
            .navbar-kasir, .no-print {
                display: none !important;
            }
            body {
                background: #ffffff;
                color: #000000;
            }
            .stat-card, .recap-table-card {
                background: #ffffff;
                color: #000000;
                border: 1px solid #ccc;
                box-shadow: none;
            }
            .table-noir th {
                background: #eee;
                color: #000;
            }
            .table-noir td {
                color: #000;
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
                <span class="text-muted ms-1 fs-6">| REKAP SHIFT KASIR</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap no-print">
            <a href="{{ route('kasir.index') }}" class="btn-pos-nav">
                <i class="bi bi-calculator"></i> Kasir POS
            </a>
            <a href="{{ route('kasir.pesanan') }}" class="btn-pos-nav">
                <i class="bi bi-clock-history"></i> Antrean Pesanan
            </a>
            <a href="{{ route('kasir.laporan') }}" class="btn-pos-nav active">
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

        <!-- Header & Date Filter -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold text-white m-0">📊 Rekapitulasi Kasir Harian</h2>
                <p class="text-muted m-0">Ringkasan perputaran transaksi, pendapatan, dan metode pembayaran</p>
            </div>

            <div class="d-flex gap-2 align-items-center no-print">
                <form action="{{ route('kasir.laporan') }}" method="GET" class="d-flex gap-2 align-items-center">
                    <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control" style="background:#2a2012; border:1px solid rgba(200,155,60,0.3); color:white; border-radius:12px;">
                    <button type="submit" class="btn btn-warning fw-bold px-3 py-2 rounded-3" style="background:var(--gold); border:none; color:#140f05;">
                        <i class="bi bi-funnel"></i> Tampilkan
                    </button>
                </form>

                <button type="button" class="btn btn-outline-light rounded-3 px-3 py-2 fw-semibold" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small text-uppercase fw-bold letter-spacing-1">Total Pendapatan Kasir</div>
                    <div class="stat-val" style="color:var(--green);">
                        Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                    </div>
                    <div class="text-muted small">Status Sudah Dibayar</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small text-uppercase fw-bold letter-spacing-1">Total Transaksi</div>
                    <div class="stat-val text-white">
                        {{ $totalTransaksi }}
                    </div>
                    <div class="text-muted small">Nota Transaksi Pesanan</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small text-uppercase fw-bold letter-spacing-1">Item Minuman / Makanan Terjual</div>
                    <div class="stat-val" style="color:var(--gold);">
                        {{ $totalItemTerjual }} Cup/Porsi
                    </div>
                    <div class="text-muted small">Volume Penjualan</div>
                </div>
            </div>
        </div>

        <!-- Breakdown by Payment Method -->
        <div class="stat-card text-start mb-4">
            <h5 class="fw-bold text-white mb-3"><i class="bi bi-pie-chart-fill text-warning me-2"></i> Rincian per Metode Pembayaran:</h5>
            <div class="row g-3">
                @foreach(['Cash', 'QRIS', 'Debit', 'Transfer'] as $mName)
                    @php
                        $mRow = $metodeSummary[$mName] ?? ['count' => 0, 'total' => 0];
                    @endphp
                    <div class="col-md-3 col-6">
                        <div class="p-3 rounded-4" style="background:#2a2012; border:1px solid rgba(200,155,60,0.2);">
                            <div class="text-muted small fw-bold">{{ $mName }}</div>
                            <div class="fw-bold fs-5 text-white my-1">Rp {{ number_format($mRow['total'], 0, ',', '.') }}</div>
                            <div class="small text-muted">{{ $mRow['count'] }} Transaksi</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Transaction Details Table -->
        <div class="recap-table-card">
            <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-white m-0">Rincian Transaksi Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</h5>
                <span class="badge" style="background:var(--gold); color:#140f05; font-size:13px;">{{ $totalTransaksi }} Nota</span>
            </div>

            <div class="table-responsive">
                <table class="table table-noir mb-0">
                    <thead>
                        <tr>
                            <th>No. Struk</th>
                            <th>Waktu</th>
                            <th>Pelanggan</th>
                            <th>Meja</th>
                            <th>Rincian Pesanan</th>
                            <th>Metode</th>
                            <th>Total Tagihan</th>
                            <th class="text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedOrders as $kode => $items)
                            @php
                                $first = $items->first();
                                $total = $items->sum('total_harga');
                            @endphp
                            <tr>
                                <td><strong style="color:var(--gold);">#{{ $kode }}</strong></td>
                                <td>{{ $first->created_at->format('H:i') }} WIB</td>
                                <td>{{ $first->nama_pembeli }}</td>
                                <td>{{ $first->nomor_meja }}</td>
                                <td>
                                    @foreach($items as $it)
                                        <div>&bull; {{ $it->menu->nama_kopi ?? 'Menu' }} ({{ $it->jumlah }}x)</div>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $first->metode_pembayaran }}</span>
                                </td>
                                <td>
                                    <strong style="color:var(--green);">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center no-print">
                                    <a href="{{ route('kasir.struk', $kode) }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3" style="border-color:var(--gold); color:var(--gold);">
                                        <i class="bi bi-printer"></i> Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Tidak ada transaksi pada tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
