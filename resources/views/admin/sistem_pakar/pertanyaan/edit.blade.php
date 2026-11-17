<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pertanyaan {{ $question->code }} — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 30px; }
        .btn-gold { background: #c89b3c; color: #140f05; font-weight: 700; border-radius: 12px; padding: 10px 24px; border: none; }
        .btn-gold:hover { background: #b88628; color: #140f05; }
    </style>
</head>
<body>

    <div class="container py-4" style="max-width: 800px;">

        <div class="mb-4">
            <a href="{{ route('admin.pertanyaan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pertanyaan
            </a>
            <h1 class="fw-bold fs-3 text-dark">Edit Pertanyaan {{ $question->code }}</h1>
            <p class="text-muted">Perbarui teks pertanyaan atau pilihan jawaban untuk konsultasi pelanggan.</p>
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
            <form action="{{ route('admin.pertanyaan.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kode Pertanyaan</label>
                        <input type="text" name="code" class="form-control rounded-3" value="{{ old('code', $question->code) }}" required>
                        <small class="text-muted">Harus unik</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Urut</label>
                        <input type="number" name="order" class="form-control rounded-3" value="{{ old('order', $question->order) }}" min="0" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tipe Input</label>
                        <select name="input_type" class="form-select rounded-3">
                            <option value="radio" {{ old('input_type', $question->input_type) == 'radio' ? 'selected' : '' }}>Radio Button</option>
                            <option value="select" {{ old('input_type', $question->input_type) == 'select' ? 'selected' : '' }}>Dropdown Select</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Teks Pertanyaan</label>
                    <textarea name="question" class="form-control rounded-3" rows="2" required>{{ old('question', $question->question) }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold m-0">Pilihan Jawaban</label>
                        <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="addOptionRow()">
                            <i class="bi bi-plus-circle"></i> Tambah Pilihan
                        </button>
                    </div>

                    <div id="optionsContainer">
                        @foreach(old('options', $question->options) as $idx => $opt)
                            <div class="row g-2 mb-2 option-row">
                                <div class="col-md-5">
                                    <input type="text" name="options[{{ $idx }}][value]" class="form-control rounded-3" placeholder="Nilai" value="{{ $opt['value'] }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="options[{{ $idx }}][label]" class="form-control rounded-3" placeholder="Label Tampilan" value="{{ $opt['label'] }}" required>
                                </div>
                                <div class="col-md-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3 mt-1" onclick="removeOptionRow(this)"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $question->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">Pertanyaan Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-check-circle-fill"></i> Perbarui Pertanyaan
                    </button>
                    <a href="{{ route('admin.pertanyaan.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>

    <script>
        let optionIndex = {{ count(old('options', $question->options)) }};
        function addOptionRow() {
            const container = document.getElementById('optionsContainer');
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 option-row';
            row.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="options[${optionIndex}][value]" class="form-control rounded-3" placeholder="Nilai (e.g. sedang)" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="options[${optionIndex}][label]" class="form-control rounded-3" placeholder="Label Tampilan" required>
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3 mt-1" onclick="removeOptionRow(this)"><i class="bi bi-x-lg"></i></button>
                </div>
            `;
            container.appendChild(row);
            optionIndex++;
        }

        function removeOptionRow(btn) {
            const rows = document.querySelectorAll('.option-row');
            if (rows.length <= 2) {
                alert('Pertanyaan harus memiliki minimal 2 pilihan jawaban.');
                return;
            }
            btn.closest('.option-row').remove();
        }
    </script>
</body>
</html>
