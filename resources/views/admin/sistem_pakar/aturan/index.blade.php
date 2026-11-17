<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base Aturan Rekomendasi — Admin NOIR COFFEE</title>

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
            padding: 18px 20px;
            vertical-align: middle;
        }
        .badge-rule {
            background: #c89b3c;
            color: #140f05;
            font-weight: 700;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 8px;
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
        .condition-badge {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            display: inline-block;
            margin: 2px;
        }
        .condition-badge code {
            font-weight: bold;
            color: #0f172a;
        }
        .menu-thumb {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>

    <div class="container-fluid px-4 py-4" style="max-width: 1400px;">

        <!-- HEADER & ACTIONS -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <a href="/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <h1 class="header-title m-0">📜 Knowledge Base: Aturan Rekomendasi (Forward Chaining)</h1>
                <p class="text-muted m-0">Kelola aturan IF–THEN sistem pakar untuk merekomendasikan menu kopi NOIR COFFEE</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.pertanyaan.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-question-circle"></i> Kelola Pertanyaan
                </a>
                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-clock-history"></i> Riwayat Konsultasi
                </a>
                <a href="{{ route('admin.aturan.create') }}" class="btn btn-gold shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Aturan Baru
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
                            <th style="width: 85px;">Kode</th>
                            <th style="width: 200px;">Nama & Deskripsi Rule</th>
                            <th style="width: 220px;">Menu Rekomendasi (THEN)</th>
                            <th>Kondisi Aturan (IF)</th>
                            <th style="width: 90px;" class="text-center">Prioritas</th>
                            <th style="width: 110px;" class="text-center">Status</th>
                            <th style="width: 150px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rules as $rule)
                            <tr>
                                <td>
                                    <span class="badge-rule">{{ $rule->code }}</span>
                                </td>
                                <td>
                                    <strong class="d-block text-dark fs-6">{{ $rule->name }}</strong>
                                    @if($rule->description)
                                        <small class="text-muted d-block mt-1">{{ Str::limit($rule->description, 70) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($rule->targetMenu)
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $imgSrc = $rule->targetMenu->gambar && file_exists(public_path('images/' . $rule->targetMenu->gambar))
                                                    ? asset('images/' . $rule->targetMenu->gambar)
                                                    : asset('images/logo.jpg');
                                            @endphp
                                            <img src="{{ $imgSrc }}" class="menu-thumb" alt="{{ $rule->targetMenu->nama_kopi }}">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $rule->targetMenu->nama_kopi }}</div>
                                                <small class="text-success fw-semibold">Rp {{ number_format($rule->targetMenu->harga, 0, ',', '.') }}</small>
                                                @if(!$rule->targetMenu->is_active)
                                                    <span class="badge bg-danger ms-1" style="font-size: 10px;">Menu Nonaktif</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> Menu tidak ditemukan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge bg-dark me-2">IF</span>
                                        @foreach($rule->conditions as $cIdx => $cond)
                                            @if($cIdx > 0)
                                                <span class="badge bg-secondary-subtle text-dark border mx-1" style="font-size: 11px;">
                                                    {{ $cond->condition_group ?: 'AND' }}
                                                </span>
                                            @endif
                                            <span class="condition-badge">
                                                <code>{{ $cond->question_code }}</code> {{ $cond->operator }} <strong>{{ $cond->expected_value }}</strong>
                                            </span>
                                        @endforeach
                                    </div>
                                    @if($rule->recommended_reason)
                                        <div class="mt-2 text-muted" style="font-size: 12px; font-style: italic;">
                                            <i class="bi bi-chat-quote"></i> "{{ Str::limit($rule->recommended_reason, 90) }}"
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $rule->priority }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.aturan.toggle', $rule->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge rounded-pill border-0 px-3 py-2 fw-semibold {{ $rule->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }}" title="Klik untuk mengubah status aktif">
                                            {{ $rule->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.aturan.edit', $rule->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3" title="Edit Aturan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.aturan.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aturan {{ $rule->code }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3" title="Hapus Aturan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada aturan knowledge base yang dibuat.
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
