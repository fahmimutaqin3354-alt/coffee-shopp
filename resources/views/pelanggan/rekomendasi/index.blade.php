<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Rekomendasi Kopi — NOIR COFFEE</title>

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
            display: flex;
            flex-direction: column;
        }

        .navbar-noir {
            background: rgba(20, 15, 5, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(200, 155, 60, 0.2);
        }

        .logo-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--gold);
            padding: 2px;
            background: var(--dark-base);
        }

        .hero-section {
            background: radial-gradient(circle at 50% 30%, rgba(200, 155, 60, 0.15) 0%, rgba(20, 15, 5, 0.95) 70%),
                        url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1400');
            background-size: cover;
            background-position: center;
            padding: 90px 20px 70px;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(200, 155, 60, 0.15);
            border: 1px solid var(--gold);
            color: var(--gold-light);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--gold);
            text-shadow: 0 0 25px rgba(200, 155, 60, 0.4);
        }

        .hero-desc {
            font-size: 19px;
            color: #d1c7b7;
            max-width: 680px;
            margin: 0 auto 35px;
            line-height: 1.6;
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4a745 0%, #b88628 100%);
            color: #140f05;
            font-weight: 700;
            padding: 16px 38px;
            border-radius: 16px;
            font-size: 18px;
            border: none;
            box-shadow: 0 8px 25px rgba(200, 155, 60, 0.35);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-gold:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(200, 155, 60, 0.5);
            color: #140f05;
        }

        .btn-outline-gold {
            background: transparent;
            color: var(--gold-light);
            font-weight: 600;
            padding: 15px 32px;
            border-radius: 16px;
            font-size: 17px;
            border: 2px solid var(--gold);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline-gold:hover {
            background: rgba(200, 155, 60, 0.15);
            color: #ffffff;
            transform: translateY(-4px);
        }

        .feature-card {
            background: var(--dark-card);
            border: 1px solid rgba(200, 155, 60, 0.2);
            border-radius: 24px;
            padding: 35px 28px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 15px 35px rgba(200, 155, 60, 0.2);
        }

        .feature-icon-box {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: rgba(200, 155, 60, 0.15);
            border: 1px solid var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--gold);
            margin-bottom: 22px;
        }

        .feature-step {
            font-size: 13px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .feature-title {
            font-size: 21px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: #bfaea0;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .footer {
            margin-top: auto;
            background: #0d0a03;
            border-top: 1px solid rgba(200, 155, 60, 0.15);
            padding: 30px 20px;
            text-align: center;
            color: #8c7e6c;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-noir sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-3" href="/">
                <img src="{{ asset('images/logo.jpg') }}" alt="Noir Coffee Logo" class="logo-img">
                <span class="fw-bold fs-4 tracking-wide text-white">NOIR <span style="color:var(--gold);">COFFEE</span></span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('pelanggan.menu') }}" class="btn btn-outline-gold btn-sm px-3 py-2 rounded-3">
                    <i class="bi bi-cup-hot"></i> Menu Kopi
                </a>
                <a href="/" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-3 text-white border-secondary">
                    <i class="bi bi-house"></i> Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="hero-badge">
                <i class="bi bi-stars"></i> Expert System &bull; Forward Chaining
            </div>
            <h1 class="hero-title">
                Temukan Cita Rasa Kopi<br><span>Sempurna untuk Jiwamu</span>
            </h1>
            <p class="hero-desc">
                Bingung memilih kopi hari ini? Sistem Pakar NOIR COFFEE menggunakan metode <strong>Forward Chaining</strong> untuk menganalisis preferensi rasa unik Anda dan merekomendasikan racikan kopi terbaik dari barista kami.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('rekomendasi.konsultasi') }}" class="btn-gold">
                    <i class="bi bi-chat-heart-fill"></i> Mulai Konsultasi
                </a>
                <a href="{{ route('pelanggan.menu') }}" class="btn-outline-gold">
                    <i class="bi bi-grid-fill"></i> Lihat Seluruh Menu
                </a>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-5" style="background: #171106;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-uppercase fw-bold" style="color:var(--gold); letter-spacing:2px; font-size:13px;">Bagaimana Sistem Bekerja</span>
                <h2 class="fw-bold mt-2 text-white" style="font-size: 34px;">3 Langkah Cerdas Menuju Kopi Idaman</h2>
                <p class="text-muted" style="max-width: 600px; margin: 10px auto 0;">Inference Engine mencocokkan fakta preferensi Anda dengan knowledge base aturan barista profesional.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-question-circle-fill"></i>
                        </div>
                        <div class="feature-step">Langkah 01</div>
                        <h3 class="feature-title">Jawab Preferensi Rasa</h3>
                        <p class="feature-desc">
                            Isi {{ $questionCount ?? 6 }} pertanyaan seputar kepekatan kopi, tingkat manis, tekstur susu/creamy, kepahitan, dominasi espresso, dan suhu minuman favoritmu.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <div class="feature-step">Langkah 02</div>
                        <h3 class="feature-title">Inferensi Forward Chaining</h3>
                        <p class="feature-desc">
                            Sistem mengumpulkan fakta jawaban Anda, mencocokkannya dengan Knowledge Base (aturan IF-THEN), dan mengeksekusi kesimpulan rule yang aktif secara deterministik.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <div class="feature-step">Langkah 03</div>
                        <h3 class="feature-title">Rekomendasi & Alasan Transparan</h3>
                        <p class="feature-desc">
                            Dapatkan menu kopi rekomendasi lengkap dengan gambar, harga asli, varian suhu, dan penjelasan rasional mengapa menu tersebut paling cocok untuk Anda.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('rekomendasi.konsultasi') }}" class="btn-gold">
                    <i class="bi bi-play-circle-fill"></i> Mulai Sekarang (Gratis & Cepat)
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p class="m-0">&copy; {{ date('Y') }} NOIR COFFEE. Sistem Pakar Rekomendasi Menu Kopi Berbasis Forward Chaining.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
