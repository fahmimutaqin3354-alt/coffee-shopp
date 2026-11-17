<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Konsultasi Pelanggan — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .header-title { font-size: 32px; font-weight: 700; color: #1f2937; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden; }
        .table th { background: #1f2937; color: white; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; padding: 16px 20px; }
        .table td { padding: 16px 20px; vertical-align: middle; }
    </style>
</head>
<body>

    <div class="container-fluid px-4 py-4" style="max-width: 1400px;">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <a href="/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <h1 class="header-title m-0">📊 Riwayat Konsultasi Rekomendasi Kopi</h1>
                <p class="text-muted m-0">Catatan aktivitas konsultasi pelanggan dan hasil inferensi Forward Chaining</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-diagram-3"></i> Aturan Rekomendasi
                </a>
                <a href="{{ route('admin.pertanyaan.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-question-circle"></i> Pertanyaan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="admin-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th style="width: 170px;">Waktu</th>
                            <th style="width: 180px;">Pelanggan / Sesi</th>
                            <th>Ringkasan Jawaban Fakta</th>
                            <th>Menu Rekomendasi</th>
                            <th style="width: 130px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $item)
                            @php
                                $summary = $item->result_summary ?? [];
                                $menus = $summary['recommended_menus'] ?? [];
                            @endphp
                            <tr>
                                <td>
                                    <span class="badge bg-dark">#{{ $item->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    @if($item->user)
                                        <div class="fw-bold text-dark"><i class="bi bi-person-fill text-primary"></i> {{ $item->user->name }}</div>
                                        <small class="text-muted">{{ $item->user->email }}</small>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border">Tamu (Guest)</span>
                                        <div style="font-size: 11px;" class="text-muted font-monospace mt-1">{{ Str::limit($item->session_id, 12) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if(is_array($item->answers))
                                            @foreach($item->answers as $code => $val)
                                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px;">
                                                    <strong>{{ $code }}:</strong> {{ $val }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(!empty($menus))
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($menus as $m)
                                                <span class="badge bg-success-subtle text-success-emphasis border px-2 py-1">
                                                    ☕ {{ $m['menu_nama'] ?? 'Menu #' . ($m['menu_id'] ?? '') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border">Tidak ada rule cocok</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.riwayat.show', $item->id) }}" class="btn btn-sm btn-outline-info rounded-3 px-3" title="Lihat Detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('admin.riwayat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus catatan riwayat konsultasi #{{ $item->id }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
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
                                    Belum ada catatan konsultasi pelanggan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($consultations->hasPages())
                <div class="p-3 border-top">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
