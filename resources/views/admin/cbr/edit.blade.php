<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasus {{ $case->kode_kasus }} CBR — NOIR COFFEE Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cbr-brown: #6f4e37;
            --cbr-brown-dark: #4a3221;
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
        }
        .btn-nav-cbr {
            background: #ffffff;
            border: 1px solid #e8d9cc;
            color: var(--cbr-brown-dark);
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .noir-card {
            background: #ffffff;
            border: 1px solid #e7ded4;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(111, 78, 55, 0.05);
        }
    </style>
</head>
<body>

    <header class="admin-nav d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill fw-bold" style="background: #e9dbce; color: var(--cbr-brown-dark); font-family: monospace; font-size: 13px;">
                {{ $case->kode_kasus }}
            </span>
            <span class="fw-bold fs-5 text-dark" style="font-family: 'Playfair Display', serif;">
                Edit Kasus CBR
            </span>
        </div>
        <a href="{{ route('admin.cbr.index') }}" class="btn-nav-cbr">
            <i class="bi bi-arrow-left"></i> Kembali ke Basis Kasus
        </a>
    </header>

    <div class="container py-4" style="max-width: 860px;">

        @if($errors->any())
            <div class="alert alert-danger rounded-4 shadow-sm border-0 mb-4">
                <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pengisian:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="noir-card">
            <h4 class="fw-bold mb-1" style="color: var(--cbr-brown-dark); font-family: 'Playfair Display', serif;">
                Penyesuaian Kasus (Revise Case)
            </h4>
            <p class="text-muted small mb-4">
                Perbarui detail kasus, gejala, atau langkah penanganan agar inferensi CBR berikutnya semakin akurat.
            </p>

            <form action="{{ route('admin.cbr.update', $case->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Judul Masalah -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Judul Masalah / Kasus <span class="text-danger">*</span></label>
                    <input type="text" name="judul_masalah" class="form-control form-control-lg rounded-3" value="{{ old('judul_masalah', $case->judul_masalah) }}" required style="font-size: 15px;">
                </div>

                <!-- Kategori Masalah -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Kategori Masalah <span class="text-danger">*</span></label>
                    <input type="text" name="kategori_masalah" list="kategoriList" class="form-control rounded-3" value="{{ old('kategori_masalah', $case->kategori_masalah) }}" required>
                    <datalist id="kategoriList">
                        @foreach($kategoris as $k)
                            <option value="{{ $k }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Gejala -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Gejala yang Terlihat / Dialami <span class="text-danger">*</span></label>
                    <div id="gejalaContainer">
                        @php $gejalaOld = old('gejala', $case->gejala ?? ['']); @endphp
                        @foreach($gejalaOld as $g)
                            <div class="input-group mb-2">
                                <input type="text" name="gejala[]" class="form-control rounded-start-2" value="{{ $g }}" required>
                                <button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" style="color: var(--cbr-brown); font-weight: 600;" onclick="addRow('gejalaContainer', 'gejala[]', 'Gejala lainnya...')">
                        <i class="bi bi-plus-circle"></i> Tambah Gejala
                    </button>
                </div>

                <!-- Kondisi -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Kondisi yang Terjadi / Penyebab Teramati <span class="text-danger">*</span></label>
                    <div id="kondisiContainer">
                        @php $kondisiOld = old('kondisi', $case->kondisi ?? ['']); @endphp
                        @foreach($kondisiOld as $k)
                            <div class="input-group mb-2">
                                <input type="text" name="kondisi[]" class="form-control rounded-start-2" value="{{ $k }}" required>
                                <button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" style="color: var(--cbr-brown); font-weight: 600;" onclick="addRow('kondisiContainer', 'kondisi[]', 'Kondisi lainnya...')">
                        <i class="bi bi-plus-circle"></i> Tambah Kondisi
                    </button>
                </div>

                <!-- Solusi Utama -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Solusi Utama <span class="text-danger">*</span></label>
                    <textarea name="solusi" rows="3" class="form-control rounded-3" required>{{ old('solusi', $case->solusi) }}</textarea>
                </div>

                <!-- Langkah Penanganan -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">Langkah Penanganan Detail (Step-by-Step)</label>
                    <div id="langkahContainer">
                        @php $langkahOld = old('langkah_penanganan', $case->langkah_penanganan ?? ['']); @endphp
                        @foreach($langkahOld as $idx => $l)
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light text-muted small">{{ $idx + 1 }}</span>
                                <input type="text" name="langkah_penanganan[]" class="form-control" value="{{ $l }}">
                                <button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" style="color: var(--cbr-brown); font-weight: 600;" onclick="addLangkahRow()">
                        <i class="bi bi-plus-circle"></i> Tambah Langkah
                    </button>
                </div>

                <!-- Bobot Kasus -->
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Bobot Kasus (0.1 - 1.0)</label>
                    <input type="number" step="0.05" min="0.1" max="1.0" name="bobot" class="form-control" style="max-width: 150px;" value="{{ old('bobot', $case->bobot) }}">
                    <div class="text-muted" style="font-size: 11px;">Semakin tinggi bobot, semakin diprioritaskan kasus ini saat penghitungan similarity.</div>
                </div>

                <!-- Verifikasi & Submit -->
                <div class="p-3 rounded-3 mb-4 d-flex align-items-center justify-content-between" style="background: #faf7f4; border: 1px solid #ebdcd0;">
                    <div>
                        <div class="fw-bold small">Status Verifikasi Kasus</div>
                        <div class="text-muted small">Tandai jika solusi ini sudah terbukti efektif di lapangan</div>
                    </div>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="verifiedSwitch" {{ old('is_verified', $case->is_verified) ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.cbr.index') }}" class="btn btn-light px-4 rounded-3">Batal</a>
                    <button type="submit" class="btn text-white fw-bold px-5 py-2.5 rounded-3" style="background: var(--cbr-brown);">
                        <i class="bi bi-save me-1"></i> Perbarui Kasus (Revise)
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script>
        function addRow(containerId, inputName, placeholder) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="${inputName}" class="form-control rounded-start-2" placeholder="${placeholder}" required>
                <button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            `;
            container.appendChild(div);
        }

        function addLangkahRow() {
            const container = document.getElementById('langkahContainer');
            const count = container.querySelectorAll('.input-group').length + 1;
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <span class="input-group-text bg-light text-muted small">${count}</span>
                <input type="text" name="langkah_penanganan[]" class="form-control" placeholder="Langkah berikutnya...">
                <button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            `;
            container.appendChild(div);
        }

        function removeRow(btn) {
            const row = btn.closest('.input-group');
            const parent = row.parentElement;
            if (parent.querySelectorAll('.input-group').length > 1) {
                row.remove();
            } else {
                row.querySelector('input').value = '';
            }
        }
    </script>
</body>
</html>
