<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertanyaan Konsultasi — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 50px;
        }
        .header-title {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }
        .admin-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .table th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            padding: 16px 20px;
        }
        .table td {
            padding: 16px 20px;
            vertical-align: middle;
        }
        .badge-code {
            background: #c89b3c;
            color: #140f05;
            font-weight: 700;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 8px;
        }
        .btn-noir {
            background: #1f2937;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 20px;
            border: none;
            transition: all 0.2s;
        }
        .btn-noir:hover {
            background: #111827;
            color: white;
            transform: translateY(-2px);
        }
        .btn-gold {
            background: #c89b3c;
            color: #140f05;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 22px;
            border: none;
            transition: all 0.2s;
        }
        .btn-gold:hover {
            background: #b88628;
            color: #140f05;
            transform: translateY(-2px);
        }
        .nav-subtabs .nav-link {
            font-weight: 600;
            color: #4b5563;
            border-radius: 12px;
            padding: 10px 20px;
            border: none;
        }
        .nav-subtabs .nav-link.active {
            background: #c89b3c;
            color: #140f05;
        }
    </style>
</head>
<body>

    <div class="container py-4">

        <!-- HEADER & BACK -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <a href="/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <h1 class="header-title m-0">❓ Daftar Pertanyaan Konsultasi Kopi</h1>
                <p class="text-muted m-0">Kelola pertanyaan dan pilihan jawaban untuk sistem pakar rekomendasi</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-diagram-3"></i> Aturan Rekomendasi
                </a>
                <a href="{{ route('admin.pertanyaan.create') }}" class="btn btn-gold shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Pertanyaan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="admin-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Kode</th>
                            <th style="width: 70px;">Urutan</th>
                            <th>Pertanyaan</th>
                            <th>Pilihan Jawaban (Label / Nilai)</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 170px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                            <tr>
                                <td>
                                    <span class="badge-code">{{ $q->code }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $q->order }}</span>
                                </td>
                                <td>
                                    <strong class="d-block fs-6 text-dark">{{ $q->question }}</strong>
                                    <small class="text-muted">Tipe input: <code>{{ $q->input_type }}</code> &bull; Dipakai di {{ $q->conditions_count }} kondisi rule</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($q->options as $opt)
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border px-2 py-1" style="font-size: 12px;">
                                                {{ $opt['label'] }} <code class="ms-1">({{ $opt['value'] }})</code>
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.pertanyaan.toggle', $q->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge rounded-pill border-0 px-3 py-2 fw-semibold cursor-pointer {{ $q->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }}" title="Klik untuk mengubah status">
                                            {{ $q->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.pertanyaan.edit', $q->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.pertanyaan.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan {{ $q->code }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada pertanyaan yang dibuat.
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
