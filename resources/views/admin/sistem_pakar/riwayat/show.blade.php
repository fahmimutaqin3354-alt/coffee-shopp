<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi #{{ $consultation->id }} — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 30px; margin-bottom: 25px; }
        .badge-rule { background: #c89b3c; color: #140f05; font-weight: 700; font-size: 13px; padding: 6px 12px; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="container py-4" style="max-width: 900px;">

        <div class="mb-4">
            <a href="{{ route('admin.riwayat.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Konsultasi
            </a>
            <h1 class="fw-bold fs-3 text-dark">Detail Konsultasi #{{ $consultation->id }}</h1>
            <p class="text-muted">Waktu: {{ $consultation->created_at->format('d M Y, H:i') }} WIB &bull; Pelanggan: {{ $consultation->user ? $consultation->user->name : 'Tamu (Session ' . Str::limit($consultation->session_id, 10) . ')' }}</p>
        </div>

        <!-- JAWABAN PELANGGAN -->
        <div class="admin-card">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-chat-left-dots-fill text-primary me-2"></i> Jawaban Fakta Preferensi Pelanggan
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 90px;">Kode</th>
                            <th>Pertanyaan</th>
                            <th>Nilai Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultation->answers as $code => $value)
                            @php
                                $q = $questions[$code] ?? null;
                            @endphp
                            <tr>
                                <td><span class="badge bg-dark">{{ $code }}</span></td>
                                <td>{{ $q ? $q->question : '-' }}</td>
                                <td>
                                    <strong class="text-primary">{{ $q ? $q->getOptionLabel($value) : $value }}</strong>
                                    <code class="ms-1 text-muted">({{ $value }})</code>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- HASIL INFERENSI -->
        @php
            $summary = $consultation->result_summary ?? [];
            $firedRules = $summary['fired_rules'] ?? [];
            $menus = $summary['recommended_menus'] ?? [];
        @endphp

        <div class="admin-card">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-diagram-3-fill text-warning me-2"></i> Aturan yang Terpenuhi (Fired Rules)
            </h5>
            @if(!empty($firedRules))
                <ul class="list-group mb-3">
                    @foreach($firedRules as $fr)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge-rule me-2">{{ $fr['code'] ?? 'RULE' }}</span>
                                <strong>{{ $fr['name'] ?? '' }}</strong>
                                <div class="text-muted small mt-1">Menu Sasaran: <strong>{{ $fr['target_menu_name'] ?? '' }}</strong></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i> Tidak ada aturan yang aktif / cocok untuk kombinasi jawaban ini.
                </div>
            @endif
        </div>

        <div class="admin-card">
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                <i class="bi bi-cup-hot-fill text-success me-2"></i> Menu Kopi yang Direkomendasikan
            </h5>
            @if(!empty($menus))
                <div class="row g-3">
                    @foreach($menus as $m)
                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2">☕ {{ $m['menu_nama'] ?? 'Menu' }}</h6>
                                <div class="small text-muted mb-2">
                                    <strong>Alasan:</strong>
                                    @foreach($m['reasons'] as $r)
                                        <div>&bull; {{ $r }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">Tidak ada menu yang direkomendasikan.</p>
            @endif
        </div>

    </div>

</body>
</html>
