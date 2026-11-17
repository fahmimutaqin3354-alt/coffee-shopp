<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Karyawan & Staff — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .header-title { font-size: 32px; font-weight: 700; color: #1f2937; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden; }
        .table th { background: #1f2937; color: white; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; padding: 16px 20px; }
        .table td { padding: 16px 20px; vertical-align: middle; }
        .badge-karyawan { background: #c89b3c; color: #140f05; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 8px; }
        .badge-admin { background: #1f2937; color: #ffffff; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 8px; }
        .btn-gold { background: #c89b3c; color: #140f05; font-weight: 700; border-radius: 12px; padding: 10px 22px; border: none; }
        .btn-gold:hover { background: #b88628; color: #140f05; }
    </style>
</head>
<body>

    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <a href="/dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
                <h1 class="header-title m-0">👥 Kelola Akun Karyawan & Kasir</h1>
                <p class="text-muted m-0">Daftar pengguna dengan hak akses Karyawan (Kasir POS) dan Administrator</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('kasir.index') }}" class="btn btn-outline-dark rounded-3 px-3 py-2 fw-semibold">
                    <i class="bi bi-calculator"></i> Buka Kasir POS
                </a>
                <a href="{{ route('admin.karyawan.create') }}" class="btn btn-gold shadow-sm">
                    <i class="bi bi-person-plus-fill"></i> Tambah Karyawan Baru
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
                            <th style="width: 70px;">ID</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat Email</th>
                            <th style="width: 140px;">Role Akses</th>
                            <th style="width: 180px;">Terdaftar Sejak</th>
                            <th style="width: 150px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyawans as $user)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark border">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <strong class="fs-6 text-dark d-block">{{ $user->name }}</strong>
                                    @if(auth()->id() === $user->id)
                                        <span class="badge bg-primary-subtle text-primary border" style="font-size: 11px;">Akun Anda</span>
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $user->email }}</code>
                                </td>
                                <td>
                                    @if($user->role === 'karyawan')
                                        <span class="badge-karyawan">
                                            <i class="bi bi-calculator me-1"></i> Karyawan (Kasir)
                                        </span>
                                    @elseif($user->role === 'admin')
                                        <span class="badge-admin">
                                            <i class="bi bi-shield-check me-1"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small text-muted">{{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.karyawan.edit', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3" title="Edit Akun">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.karyawan.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3" title="Hapus Akun">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    Belum ada data akun karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($karyawans->hasPages())
                <div class="p-3 border-top">
                    {{ $karyawans->links() }}
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
