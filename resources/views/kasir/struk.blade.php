<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $first->kode_pesanan }} — NOIR COFFEE</title>

    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #2b2b2b;
            font-family: 'Courier Prime', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 30px 15px;
        }

        .receipt-container {
            width: 340px;
            background: #ffffff;
            color: #000000;
            padding: 24px 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.4;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo-receipt {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 8px;
            filter: grayscale(100%);
        }

        .cafe-name {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .cafe-tagline {
            font-size: 11px;
            color: #333333;
            margin-bottom: 8px;
        }

        .dashed-line {
            border-bottom: 1px dashed #000000;
            margin: 10px 0;
        }

        .double-dashed-line {
            border-bottom: 2px dashed #000000;
            margin: 12px 0;
        }

        .meta-table {
            width: 100%;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .meta-table td {
            padding: 2px 0;
        }

        .items-table {
            width: 100%;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .items-table th {
            text-align: left;
            padding-bottom: 6px;
            border-bottom: 1px dashed #000;
        }

        .items-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: 100%;
            font-size: 13px;
        }

        .summary-table td {
            padding: 3px 0;
        }

        .grand-total-row {
            font-size: 15px;
            font-weight: 700;
        }

        .receipt-footer {
            text-align: center;
            font-size: 11px;
            margin-top: 15px;
            line-height: 1.5;
        }

        .action-bar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            background: rgba(20, 15, 5, 0.95);
            padding: 12px 20px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6);
            border: 1px solid #c89b3c;
            z-index: 100;
        }

        .btn-print {
            background: #c89b3c;
            color: #140f05;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            border: none;
            padding: 10px 24px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-print:hover {
            background: #b88628;
        }

        .btn-back {
            background: #2a2012;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back:hover {
            background: #342818;
            color: #ffffff;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
                margin: 0;
            }
            .receipt-container {
                width: 100%;
                max-width: 80mm;
                box-shadow: none;
                padding: 5mm;
                border-radius: 0;
            }
            .action-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-container">

        <!-- HEADER -->
        <div class="receipt-header">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logo-receipt">
            <div class="cafe-name">NOIR COFFEE</div>
            <div class="cafe-tagline">Specialty Coffee & Cozy Ambiance</div>
            <div style="font-size: 10px; color:#555;">Jl. Noir Boulevard No. 17 &bull; @noircoffee</div>
        </div>

        <div class="dashed-line"></div>

        <!-- META INFO -->
        <table class="meta-table">
            <tr>
                <td>No. Struk</td>
                <td class="text-right"><strong>#{{ $first->kode_pesanan }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td class="text-right">{{ $first->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td class="text-right">{{ $first->nama_pembeli }}</td>
            </tr>
            <tr>
                <td>No. Meja</td>
                <td class="text-right">{{ $first->nomor_meja }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td class="text-right">{{ $first->kasir_nama ?: 'Kasir Noir' }}</td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        <!-- ITEMS -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanans as $item)
                    <tr>
                        <td>
                            {{ $item->menu->nama_kopi ?? 'Menu' }}
                            <div style="font-size: 10px; color: #555;">@ Rp {{ number_format($item->menu->harga ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="double-dashed-line"></div>

        <!-- TOTALS -->
        <table class="summary-table">
            <tr class="grand-total-row">
                <td>TOTAL TAGIHAN</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Metode Bayar</td>
                <td class="text-right">{{ $first->metode_pembayaran }}</td>
            </tr>
            @if($first->uang_diterima)
                <tr>
                    <td>Uang Diterima</td>
                    <td class="text-right">Rp {{ number_format($first->uang_diterima, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td class="text-right">Rp {{ number_format($first->kembalian, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <td>Status Bayar</td>
                <td class="text-right"><strong>{{ strtoupper($first->status_pembayaran) }}</strong></td>
            </tr>
        </table>

        <div class="dashed-line"></div>

        <!-- FOOTER -->
        <div class="receipt-footer">
            <div>Terima Kasih atas Kunjungan Anda!</div>
            <div>Selamat Menikmati Racikan Kopi Terbaik NOIR COFFEE.</div>
            <div style="margin-top: 8px; font-size: 9px; color: #777;">Simpan struk ini sebagai bukti transaksi resmi.</div>
        </div>

    </div>

    <!-- ACTION BAR (HIDDEN DURING PRINT) -->
    <div class="action-bar">
        <button type="button" class="btn-print" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
        <a href="{{ route('kasir.index') }}" class="btn-back">
            ← Kasir POS
        </a>
        <a href="{{ route('kasir.pesanan') }}" class="btn-back">
            📋 Antrean
        </a>
    </div>

</body>
</html>
