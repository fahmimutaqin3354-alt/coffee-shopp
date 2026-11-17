<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun {{ $karyawan->name }} — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 30px; }
        .btn-gold { background: #c89b3c; color: #140f05; font-weight: 700; border-radius: 12px; padding: 12px 28px; border: none; }
        .btn-gold:hover { background: #b88628; color: #140f05; }
    </style>
</head>
<body>

    <div class="container py-4" style="max-width: 650px;">

        <div class="mb-4">
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Karyawan
            </a>
            <h1 class="fw-bold fs-3 text-dark">Edit Akun {{ $karyawan->name }}</h1>
            <p class="text-muted">Perbarui data login atau role pengguna</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-card">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Karyawan / Kasir</label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $karyawan->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email (Untuk Login)</label>
                    <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $karyawan->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="Minimal 6 karakter jika diisi">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Role Akses</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="karyawan" {{ old('role', $karyawan->role) === 'karyawan' ? 'selected' : '' }}>
                            🛒 Karyawan (Akses Kasir POS, Antrean Pesanan, Cetak Struk)
                        </option>
                        <option value="admin" {{ old('role', $karyawan->role) === 'admin' ? 'selected' : '' }}>
                            🛡️ Administrator (Akses Penuh Seluruh Dashboard & Knowledge Base)
                        </option>
                        <option value="pelanggan" {{ old('role', $karyawan->role) === 'pelanggan' ? 'selected' : '' }}>
                            👤 Pelanggan Biasa
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-check-circle-fill"></i> Perbarui Akun
                    </button>
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
