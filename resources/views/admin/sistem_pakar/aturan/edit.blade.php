<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aturan {{ $rule->code }} — Admin NOIR COFFEE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .admin-card { background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; padding: 30px; }
        .btn-gold { background: #c89b3c; color: #140f05; font-weight: 700; border-radius: 12px; padding: 12px 28px; border: none; }
        .btn-gold:hover { background: #b88628; color: #140f05; }
        .condition-row { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; margin-bottom: 12px; }
    </style>
</head>
<body>

    <div class="container py-4" style="max-width: 900px;">

        <div class="mb-4">
            <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Aturan
            </a>
            <h1 class="fw-bold fs-3 text-dark">Edit Aturan {{ $rule->code }}</h1>
            <p class="text-muted">Perbarui kondisi logika IF-THEN atau menu rekomendasi.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-4">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Terdapat kesalahan validasi:</div>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-card">
            <form action="{{ route('admin.aturan.update', $rule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- RULE BASIC INFO -->
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Aturan</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kode Aturan</label>
                        <input type="text" name="code" class="form-control rounded-3" value="{{ old('code', $rule->code) }}" required>
                        <small class="text-muted">Kode unik rule</small>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-bold">Nama Aturan</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $rule->name) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Prioritas</label>
                        <input type="number" name="priority" class="form-control rounded-3" value="{{ old('priority', $rule->priority) }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi Aturan (Opsional)</label>
                    <textarea name="description" class="form-control rounded-3" rows="2">{{ old('description', $rule->description) }}</textarea>
                </div>

                <!-- TARGET MENU -->
                <h5 class="fw-bold text-dark border-bottom pb-2 mt-4 mb-3">Menu Tujuan Rekomendasi (THEN)</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Pilih Menu Dari Database</label>
                        <select name="target_menu_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Menu Kopi --</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}" {{ old('target_menu_id', $rule->target_menu_id) == $menu->id ? 'selected' : '' }}>
                                    {{ $menu->nama_kopi }} ({{ $menu->kategori }} &bull; Rp {{ number_format($menu->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Alasan Rekomendasi (Explanation Facility)</label>
                        <textarea name="recommended_reason" class="form-control rounded-3" rows="3" required>{{ old('recommended_reason', $rule->recommended_reason) }}</textarea>
                        <small class="text-muted">Teks ini akan ditampilkan kepada pelanggan sebagai penjelasan rekomendasi.</small>
                    </div>
                </div>

                <!-- CONDITIONS BUILDER -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mt-4 mb-3">
                    <h5 class="fw-bold text-dark m-0">Kondisi Pertanyaan (IF)</h5>
                    <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="addConditionRow()">
                        <i class="bi bi-plus-circle"></i> Tambah Kondisi
                    </button>
                </div>

                <div id="conditionsContainer">
                    @php
                        $conditionsList = old('conditions', $rule->conditions->toArray());
                    @endphp

                    @foreach($conditionsList as $idx => $cond)
                        <div class="condition-row">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted m-0">Pertanyaan</label>
                                    <select name="conditions[{{ $idx }}][question_code]" class="form-select form-select-sm rounded-3 question-select" required>
                                        @foreach($questions as $q)
                                            <option value="{{ $q->code }}" {{ ($cond['question_code'] ?? '') == $q->code ? 'selected' : '' }}>
                                                {{ $q->code }} - {{ Str::limit($q->question, 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted m-0">Operator</label>
                                    <select name="conditions[{{ $idx }}][operator]" class="form-select form-select-sm rounded-3" required>
                                        <option value="=" {{ ($cond['operator'] ?? '=') == '=' ? 'selected' : '' }}>=</option>
                                        <option value="!=" {{ ($cond['operator'] ?? '') == '!=' ? 'selected' : '' }}>!=</option>
                                        <option value="in" {{ ($cond['operator'] ?? '') == 'in' ? 'selected' : '' }}>IN (salah satu)</option>
                                        <option value="not_in" {{ ($cond['operator'] ?? '') == 'not_in' ? 'selected' : '' }}>NOT IN</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted m-0">Nilai Jawaban yang Diharapkan</label>
                                    <input type="text" name="conditions[{{ $idx }}][expected_value]" class="form-control form-control-sm rounded-3 expected-input" value="{{ $cond['expected_value'] ?? '' }}" required>
                                </div>

                                <div class="col-md-1">
                                    <label class="form-label small fw-bold text-muted m-0">Grup</label>
                                    <select name="conditions[{{ $idx }}][condition_group]" class="form-select form-select-sm rounded-3">
                                        <option value="AND" {{ ($cond['condition_group'] ?? 'AND') == 'AND' ? 'selected' : '' }}>AND</option>
                                        <option value="OR" {{ ($cond['condition_group'] ?? '') == 'OR' ? 'selected' : '' }}>OR</option>
                                    </select>
                                </div>

                                <div class="col-md-1 text-center pt-3">
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="removeConditionRow(this)"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $rule->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="isActive">Aturan Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-check-circle-fill"></i> Perbarui Aturan
                    </button>
                    <a href="{{ route('admin.aturan.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>

    <script>
        const questionsData = @json($questions);
        let conditionIndex = {{ count($conditionsList) }};

        function addConditionRow() {
            const container = document.getElementById('conditionsContainer');
            const row = document.createElement('div');
            row.className = 'condition-row';
            
            let questionOptionsHtml = '';
            questionsData.forEach(q => {
                questionOptionsHtml += `<option value="${q.code}">${q.code} - ${q.question.substring(0, 40)}...</option>`;
            });

            row.innerHTML = `
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted m-0">Pertanyaan</label>
                        <select name="conditions[${conditionIndex}][question_code]" class="form-select form-select-sm rounded-3 question-select" required>
                            ${questionOptionsHtml}
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted m-0">Operator</label>
                        <select name="conditions[${conditionIndex}][operator]" class="form-select form-select-sm rounded-3" required>
                            <option value="=">=</option>
                            <option value="!=">!=</option>
                            <option value="in">IN (salah satu)</option>
                            <option value="not_in">NOT IN</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted m-0">Nilai Jawaban yang Diharapkan</label>
                        <input type="text" name="conditions[${conditionIndex}][expected_value]" class="form-control form-control-sm rounded-3 expected-input" placeholder="e.g. ya, tinggi, rendah" required>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label small fw-bold text-muted m-0">Grup</label>
                        <select name="conditions[${conditionIndex}][condition_group]" class="form-select form-select-sm rounded-3">
                            <option value="AND">AND</option>
                            <option value="OR">OR</option>
                        </select>
                    </div>

                    <div class="col-md-1 text-center pt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="removeConditionRow(this)"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(row);
            conditionIndex++;
        }

        function removeConditionRow(btn) {
            const rows = document.querySelectorAll('.condition-row');
            if (rows.length <= 1) {
                alert('Aturan harus memiliki minimal 1 kondisi.');
                return;
            }
            btn.closest('.condition-row').remove();
        }
    </script>
</body>
</html>
