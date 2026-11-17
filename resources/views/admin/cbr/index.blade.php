<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basis Kasus (Case Base) CBR — NOIR COFFEE Admin</title>

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
        }

        body {
            background-color: var(--cbr-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2b2b;
            padding-bottom: 60px;
        }

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

        .stat-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 4px 16px rgba(111, 78, 55, 0.05);
            transition: all 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }

        .noir-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(111, 78, 55, 0.05);
        }

        .table-cbr th {
            background: #4a3221;
            color: #ffffff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 14px 16px;
        }
        .table-cbr td {
            padding: 16px;
            vertical-align: middle;
            font-size: 13px;
            border-bottom: 1px solid #f0e6dc;
        }

        .tag-pill {
            background: #f4ece4;
            border: 1px solid #e1cfbf;
            color: #4a3221;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 11px;
            display: inline-block;
            margin: 2px;
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
            <a href="{{ route('admin.cbr.konsultasi') }}" class="btn-nav-cbr">
                <i class="bi bi-search"></i> Solusi Masalah (CBR)
            </a>
            <a href="{{ route('admin.cbr.index') }}" class="btn-nav-cbr active">
                <i class="bi bi-database-check"></i> Basis Kasus (Case Base)
            </a>
            <a href="{{ route('admin.cbr.create') }}" class="btn-nav-cbr" style="background: var(--cbr-brown); color: #ffffff;">
                <i class="bi bi-plus-circle"></i> Tambah Kasus
            </a>
        </div>
    </header>

    <div class="container py-4" style="max-width: 1140px;">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" style="background: rgba(34, 197, 94, 0.15); border: 1px solid #22c55e; color: #15803d;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- HEADER & ACTIONS -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--cbr-brown-dark); font-family: 'Playfair Display', serif;">
                    Basis Kasus Operasional (Case Base)
                </h2>
                <p class="text-muted small mb-0">
                    Kumpulan kasus permasalahan operasional coffee shop yang menjadi sumber rujukan mesin inferensi Case Based Reasoning.
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.cbr.konsultasi') }}" class="btn fw-bold px-4 py-2 rounded-3 text-white" style="background: var(--cbr-brown);">
                    <i class="bi bi-search me-1"></i> Buka CBR Solver
                </a>
                <a href="{{ route('admin.cbr.create') }}" class="btn btn-outline-dark fw-bold px-3 py-2 rounded-3">
                    <i class="bi bi-plus-lg me-1"></i> Kasus Baru
                </a>
            </div>
        </div>

        <!-- STATS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="text-muted small mb-1">Total Kasus Tersimpan</div>
                    <div class="fs-3 fw-bold" style="color: var(--cbr-brown-dark);">{{ $stats['total'] }} Kasus</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="text-muted small mb-1">Kasus Terverifikasi (Solutif)</div>
                    <div class="fs-3 fw-bold text-success">{{ $stats['verified'] }} Teruji</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="text-muted small mb-1">Kasus Aktif</div>
                    <div class="fs-3 fw-bold" style="color: var(--cbr-warm);">{{ $stats['active'] }} Aktif</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="text-muted small mb-1">Kategori Masalah</div>
                    <div class="fs-3 fw-bold text-dark">{{ $stats['kategoris'] }} Kategori</div>
                </div>
            </div>
        </div>

        <!-- CASES TABLE -->
        <div class="noir-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-cbr mb-0">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Kode</th>
                            <th>Judul Masalah</th>
                            <th>Kategori</th>
                            <th>Gejala &amp; Kondisi</th>
                            <th>Solusi</th>
                            <th style="width: 90px;" class="text-center">Status</th>
                            <th style="width: 130px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr style="{{ !$case->is_active ? 'opacity: 0.6; background: #fbfbfb;' : '' }}">
                                <td>
                                    <span class="badge rounded-pill fw-bold" style="background: #e9dbce; color: var(--cbr-brown-dark); font-family: monospace;">
                                        {{ $case->kode_kasus }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $case->judul_masalah }}</div>
                                    @if($case->is_verified)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill" style="font-size: 10px;">
                                            <i class="bi bi-patch-check-fill"></i> Terverifikasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background: #f0e6dc; color: #4a3221; font-weight: 600;">
                                        {{ $case->kategori_masalah }}
                                    </span>
                                </td>
                                <td style="max-width: 260px;">
                                    <div class="mb-1">
                                        <span class="text-muted" style="font-size: 11px;">Gejala:</span><br>
                                        @foreach($case->gejala ?? [] as $g)
                                            <span class="tag-pill">{{ $g }}</span>
                                        @endforeach
                                    </div>
                                    <div>
                                        <span class="text-muted" style="font-size: 11px;">Kondisi:</span><br>
                                        @foreach($case->kondisi ?? [] as $k)
                                            <span class="tag-pill" style="background: #eef2f6; border-color: #cbd5e1; color: #334155;">{{ $k }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td style="max-width: 280px;">
                                    <div class="small text-muted" style="line-height: 1.5;">
                                        {{ \Illuminate\Support\Str::limit($case->solusi, 120) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.cbr.toggle', $case->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm rounded-pill px-2 py-0 border-0" style="font-size: 11px;" title="Klik untuk ubah status">
                                            @if($case->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.cbr.edit', $case->id) }}" class="btn btn-sm btn-outline-secondary rounded-2" title="Edit Kasus">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.cbr.destroy', $case->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kasus ini dari Case Base?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Hapus Kasus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder2-open fs-1 d-block mb-2"></i>
                                    Belum ada kasus yang tersimpan di Case Base.
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
