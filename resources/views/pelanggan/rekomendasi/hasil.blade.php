<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi Kopi — NOIR COFFEE</title>

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
            --green: #22c55e;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-base);
            color: #f8f3e7;
            min-height: 100vh;
            padding-bottom: 70px;
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

        .result-header {
            text-align: center;
            padding: 40px 15px 30px;
        }

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(200, 155, 60, 0.15);
            border: 1px solid var(--gold);
            color: var(--gold-light);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .result-title {
            font-size: 38px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .result-title span {
            color: var(--gold);
        }

        .result-desc {
            font-size: 16px;
            color: #bfaea0;
            max-width: 620px;
            margin: 0 auto;
        }

        .recommendation-card {
            background: var(--dark-card);
            border: 1px solid rgba(200, 155, 60, 0.25);
            border-radius: 28px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            margin-bottom: 35px;
        }

        .recommendation-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px rgba(200, 155, 60, 0.25);
        }

        .menu-photo {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: #251b0f;
            display: block;
        }

        .card-inner {
            padding: 30px;
        }

        .menu-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .price-badge {
            color: var(--green);
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 15px;
            display: inline-block;
        }

        .menu-desc {
            color: #d1c7b7;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        /* EXPLANATION FACILITY */
        .explanation-box {
            background: rgba(200, 155, 60, 0.08);
            border: 1px solid rgba(200, 155, 60, 0.35);
            border-left: 5px solid var(--gold);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .explanation-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gold-light);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .explanation-text {
            color: #f5eee3;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .rule-tags {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .rule-tag {
            background: rgba(20, 15, 5, 0.8);
            border: 1px solid rgba(200, 155, 60, 0.3);
            color: var(--gold-light);
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 8px;
        }

        .serving-pill {
            background: #2a2012;
            color: #e5dec2;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-order-now {
            background: var(--green);
            color: #ffffff;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 14px;
            font-size: 16px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-order-now:hover {
            background: #16a34a;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-add-cart {
            background: rgba(200, 155, 60, 0.15);
            color: var(--gold-light);
            border: 1px solid var(--gold);
            font-weight: 600;
            padding: 14px 24px;
            border-radius: 14px;
            font-size: 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-add-cart:hover {
            background: var(--gold);
            color: #140f05;
            transform: translateY(-2px);
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4a745 0%, #b88628 100%);
            color: #140f05;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 14px;
            font-size: 16px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            color: #140f05;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(200, 155, 60, 0.4);
        }

        .empty-state {
            background: var(--dark-card);
            border: 1px dashed rgba(200, 155, 60, 0.35);
            border-radius: 28px;
            padding: 60px 30px;
            text-align: center;
            margin: 30px 0;
        }

        .empty-icon {
            font-size: 65px;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .facts-card {
            background: #191207;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 22px;
            margin-top: 35px;
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
                <a href="{{ route('rekomendasi.konsultasi') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 text-white border-secondary">
                    <i class="bi bi-arrow-repeat"></i> Ulangi Konsultasi
                </a>
                <a href="{{ route('pelanggan.menu') }}" class="btn btn-outline-gold btn-sm px-3 py-2 rounded-3" style="border: 1px solid var(--gold); color: var(--gold-light);">
                    <i class="bi bi-grid"></i> Semua Menu
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 900px;">

        <!-- HEADER -->
        <div class="result-header">
            <div class="result-badge">
                <i class="bi bi-stars"></i> Rekomendasi Terverifikasi
            </div>
            <h1 class="result-title">
                Rekomendasi Kopi <span>untuk Anda</span>
            </h1>
            <p class="result-desc">
                Inference Engine Forward Chaining berhasil menganalisis preferensi rasa Anda dan mencocokkannya dengan Knowledge Base aturan barista NOIR COFFEE.
            </p>
        </div>

        @if(session('info'))
            <div class="alert alert-info rounded-4 mb-4">
                {{ session('info') }}
            </div>
        @endif

        @if($hasMatches && count($recommendations) > 0)
            <!-- LIST REKOMENDASI -->
            <div class="row g-4">
                @foreach($recommendations as $rec)
                    @php
                        $menu = $rec['menu'];
                        $imagePath = $menu->gambar && file_exists(public_path('images/' . $menu->gambar))
                            ? asset('images/' . $menu->gambar)
                            : asset('images/logo.jpg');
                    @endphp

                    <div class="col-12">
                        <div class="recommendation-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="{{ $imagePath }}" 
                                         alt="{{ $menu->nama_kopi }}" 
                                         class="menu-photo"
                                         onerror="this.src='{{ asset('images/logo.jpg') }}'">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                            <span class="badge rounded-pill px-3 py-2" style="background:#6f4e37; font-size:13px;">
                                                {{ $menu->kategori }}
                                            </span>
                                            @if(!empty($rec['serving_suggestion']))
                                                <span class="serving-pill">
                                                    <i class="bi bi-thermometer-half" style="color:var(--gold);"></i>
                                                    {{ $rec['serving_suggestion'] }}
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="menu-title">{{ $menu->nama_kopi }}</h2>
                                        <div class="price-badge">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>

                                        <p class="menu-desc">{{ $menu->deskripsi }}</p>

                                        <!-- EXPLANATION FACILITY -->
                                        <div class="explanation-box">
                                            <div class="explanation-title">
                                                <i class="bi bi-lightbulb-fill"></i> Alasan Rekomendasi
                                            </div>
                                            @foreach($rec['reasons'] as $reason)
                                                <p class="explanation-text mb-2">&bull; {{ $reason }}</p>
                                            @endforeach

                                            @if(!empty($rec['matched_rules']))
                                                <div class="rule-tags">
                                                    <span class="text-muted" style="font-size: 11px; align-self: center;">Rule cocok:</span>
                                                    @foreach($rec['matched_rules'] as $ruleText)
                                                        <span class="rule-tag">{{ $ruleText }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- ACTION BUTTONS -->
                                        <div class="d-flex align-items-center gap-3 flex-wrap">
                                            <!-- Direct Order / Pesan Sekarang -->
                                            <a href="{{ route('pelanggan.pesan', $menu->id) }}" class="btn-order-now">
                                                <i class="bi bi-bag-check-fill"></i> Pesan Sekarang
                                            </a>

                                            <!-- Add to Cart -->
                                            <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-add-cart">
                                                    <i class="bi bi-cart-plus"></i> + Keranjang
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- EMPTY STATE: KETIKA TIDAK ADA RULE YANG COCOK -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <h3 class="fw-bold text-white mb-3" style="font-size: 26px;">Belum Menemukan Rekomendasi yang Cocok</h3>
                <p class="text-muted mb-4" style="max-width: 550px; margin: 0 auto 25px; line-height: 1.6;">
                    Kombinasi preferensi rasa yang Anda masukkan belum cocok dengan aturan racikan kopi dalam knowledge base kami. Silakan coba kembali dengan preferensi yang berbeda atau telusuri menu kopi lengkap kami.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('rekomendasi.konsultasi') }}" class="btn-gold">
                        <i class="bi bi-arrow-repeat"></i> Ulangi Konsultasi
                    </a>
                    <a href="{{ route('pelanggan.menu') }}" class="btn btn-outline-secondary px-4 py-3 rounded-4 text-white border-secondary">
                        <i class="bi bi-grid-fill"></i> Lihat Seluruh Menu
                    </a>
                </div>
            </div>
        @endif

        <!-- TRANSPARENCY: DATA JAWABAN KONSULTASI -->
        <div class="facts-card">
            <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2" style="font-size: 16px;">
                <i class="bi bi-clipboard2-check-fill" style="color:var(--gold);"></i> Ringkasan Preferensi yang Anda Masukkan:
            </h5>
            <div class="row g-2">
                @foreach($userAnswers as $code => $ans)
                    @php
                        $q = $questions[$code] ?? null;
                        $qText = $q ? $q->question : $code;
                        $ansLabel = $q ? $q->getOptionLabel($ans) : $ans;
                    @endphp
                    <div class="col-md-6">
                        <div class="p-2 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <div class="text-muted" style="font-size: 12px;">{{ $code }}: {{ $qText }}</div>
                            <div class="fw-bold" style="color: var(--gold-light); font-size: 14px;">{{ $ansLabel }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- BOTTOM NAVIGATION -->
        <div class="text-center mt-5 pt-3">
            <a href="{{ route('rekomendasi.konsultasi') }}" class="btn-gold me-2">
                <i class="bi bi-arrow-repeat"></i> Coba Preferensi Lain
            </a>
            <a href="{{ route('pelanggan.menu') }}" class="btn btn-outline-secondary px-4 py-3 rounded-4 text-white border-secondary">
                <i class="bi bi-cup-hot"></i> Kembali ke Menu Kopi
            </a>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
