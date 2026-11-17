<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Preferensi Kopi — NOIR COFFEE</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #c89b3c;
            --gold-light: #e5c378;
            --dark-base: #140f05;
            --dark-card: #1f170b;
            --dark-surface: #2a2012;
            --cream: #f5eee3;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-base);
            color: #f8f3e7;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        .navbar-noir {
            background: rgba(20, 15, 5, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(200, 155, 60, 0.2);
        }

        .logo-img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--gold);
            padding: 2px;
            background: var(--dark-base);
        }

        .progress-container {
            background: var(--dark-card);
            border: 1px solid rgba(200, 155, 60, 0.25);
            border-radius: 20px;
            padding: 20px 25px;
            margin-bottom: 35px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .progress {
            background-color: rgba(255, 255, 255, 0.08);
            height: 12px;
            border-radius: 10px;
        }

        .progress-bar {
            background: linear-gradient(90deg, #b88628 0%, #e5c378 100%);
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .question-card {
            background: var(--dark-card);
            border: 1px solid rgba(200, 155, 60, 0.2);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .question-card:hover {
            border-color: rgba(200, 155, 60, 0.45);
        }

        .question-card.has-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);
        }

        .question-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 22px;
        }

        .question-code-badge {
            background: rgba(200, 155, 60, 0.15);
            border: 1px solid var(--gold);
            color: var(--gold-light);
            font-size: 14px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 12px;
            letter-spacing: 0.5px;
        }

        .question-title {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
            line-height: 1.4;
        }

        .option-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
        }

        .option-label {
            display: block;
            position: relative;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }

        .option-label input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .option-box {
            background: var(--dark-surface);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.25s ease;
            color: #e5dec2;
            font-weight: 500;
            font-size: 16px;
        }

        .option-box:hover {
            border-color: rgba(200, 155, 60, 0.5);
            background: #342818;
            transform: translateY(-2px);
            color: #ffffff;
        }

        .option-radio-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .option-radio-dot::after {
            content: '';
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #140f05;
            display: none;
        }

        .option-label input[type="radio"]:checked ~ .option-box {
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.2) 0%, rgba(200, 155, 60, 0.05) 100%);
            border-color: var(--gold);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(200, 155, 60, 0.25);
        }

        .option-label input[type="radio"]:checked ~ .option-box .option-radio-dot {
            border-color: var(--gold);
            background: var(--gold);
        }

        .option-label input[type="radio"]:checked ~ .option-box .option-radio-dot::after {
            display: block;
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4a745 0%, #b88628 100%);
            color: #140f05;
            font-weight: 700;
            padding: 18px 40px;
            border-radius: 18px;
            font-size: 19px;
            border: none;
            box-shadow: 0 8px 25px rgba(200, 155, 60, 0.35);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(200, 155, 60, 0.5);
            color: #140f05;
        }

        .btn-gold:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sub-header {
            text-align: center;
            margin: 40px 0 35px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-noir sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('rekomendasi.index') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Noir Coffee Logo" class="logo-img">
                <span class="fw-bold fs-4 text-white">NOIR <span style="color:var(--gold);">COFFEE</span></span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('rekomendasi.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 text-white border-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 820px;">

        <div class="sub-header">
            <span class="text-uppercase fw-bold" style="color:var(--gold); letter-spacing:2px; font-size:12px;">
                <i class="bi bi-compass"></i> Kuesioner Preferensi Rasa
            </span>
            <h1 class="fw-bold mt-2 text-white" style="font-size: 32px;">Pilih Preferensi Kopi Anda</h1>
            <p class="text-muted" style="font-size: 15px;">Jawab pertanyaan berikut dengan jujur agar mesin inferensi Forward Chaining dapat menemukan menu yang paling pas.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 p-3 mb-4 border-0" style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5;">
                <div class="d-flex align-items-center gap-2 mb-2 fw-bold">
                    <i class="bi bi-exclamation-triangle-fill"></i> Mohon lengkapi semua jawaban yang wajib diisi:
                </div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- PROGRESS BAR -->
        <div class="progress-container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-white fs-6">Progres Pengisian</span>
                <span class="fw-bold" style="color:var(--gold);" id="progressText">0 / {{ count($questions) }} Terjawab</span>
            </div>
            <div class="progress">
                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <!-- FORM KONSULTASI -->
        <form action="{{ route('rekomendasi.proses') }}" method="POST" id="consultationForm">
            @csrf

            @foreach($questions as $index => $q)
                <div class="question-card {{ $errors->has($q->code) ? 'has-error' : '' }}" id="card-{{ $q->code }}">
                    <div class="question-header">
                        <span class="question-code-badge">{{ $q->code }}</span>
                        <h2 class="question-title">{{ $q->question }}</h2>
                    </div>

                    <div class="option-group">
                        @foreach($q->options as $opt)
                            <label class="option-label">
                                <input type="radio" 
                                       name="{{ $q->code }}" 
                                       value="{{ $opt['value'] }}"
                                       {{ old($q->code) === $opt['value'] ? 'checked' : '' }}
                                       onchange="updateProgress()"
                                       required>
                                <div class="option-box">
                                    <div class="option-radio-dot"></div>
                                    <span>{{ $opt['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if($errors->has($q->code))
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first($q->code) }}
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="mt-4 pt-2">
                <button type="submit" class="btn-gold" id="btnSubmit">
                    <i class="bi bi-cpu-fill"></i>
                    <span>Analisis & Rekomendasikan Menu</span>
                </button>
            </div>
        </form>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const totalQuestions = {{ count($questions) }};

        function updateProgress() {
            const form = document.getElementById('consultationForm');
            const answeredNames = new Set();

            const radios = form.querySelectorAll('input[type="radio"]:checked');
            radios.forEach(r => answeredNames.add(r.name));

            const answeredCount = answeredNames.size;
            const percentage = Math.round((answeredCount / totalQuestions) * 100);

            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressText').innerText = answeredCount + ' / ' + totalQuestions + ' Terjawab';
        }

        // Initialize progress on page load (in case of old inputs)
        document.addEventListener('DOMContentLoaded', () => {
            updateProgress();
        });
    </script>
</body>
</html>
