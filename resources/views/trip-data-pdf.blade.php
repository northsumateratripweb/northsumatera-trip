<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perjalanan - {{ $tripData->nama_pelanggan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #FF4433;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #FF4433;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #FF4433;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item {
            padding: 10px;
            background: #f9f9f9;
            border-left: 3px solid #FF4433;
        }
        .info-label {
            font-weight: bold;
            color: #333;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .info-value {
            color: #666;
            font-size: 14px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #ffc107; color: #000; }
        .status-confirmed { background: #17a2b8; color: #fff; }
        .status-ongoing { background: #28a745; color: #fff; }
        .status-completed { background: #28a745; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN PERJALANAN</h1>
            <p>{{ \App\Models\Setting::firstOrCreateDefault()->company_name ?? 'NorthSumateraTrip' }}</p>
        </div>

        <div class="section">
            <div class="section-title">Informasi Pelanggan</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Pelanggan</div>
                    <div class="info-value">{{ $tripData->nama_pelanggan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nomor HP</div>
                    <div class="info-value">{{ $tripData->nomor_hp }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">{{ $tripData->tanggal->format('d F Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $tripData->status }}">
                            {{ ucfirst($tripData->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detail Perjalanan</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Layanan</div>
                    <div class="info-value">{{ $tripData->layanan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jumlah Hari</div>
                    <div class="info-value">{{ $tripData->jumlah_hari }} hari</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jumlah Penumpang</div>
                    <div class="info-value">{{ $tripData->penumpang }} orang</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Drone</div>
                    <div class="info-value">{{ $tripData->drone ? 'Ya' : 'Tidak' }}</div>
                </div>
                @if($tripData->nama_driver)
                <div class="info-item">
                    <div class="info-label">Nama Driver</div>
                    <div class="info-value">{{ $tripData->nama_driver }}</div>
                </div>
                @endif
                @if($tripData->plat_mobil)
                <div class="info-item">
                    <div class="info-label">Plat Mobil</div>
                    <div class="info-value">{{ $tripData->plat_mobil }}</div>
                </div>
                @endif
                @if($tripData->jenis_mobil)
                <div class="info-item">
                    <div class="info-label">Jenis Mobil</div>
                    <div class="info-value">{{ $tripData->jenis_mobil }}</div>
                </div>
                @endif
            </div>
        </div>

        @if($tripData->hotel_1 || $tripData->hotel_2 || $tripData->hotel_3 || $tripData->hotel_4)
        <div class="section">
            <div class="section-title">Akomodasi Hotel</div>
            <div class="info-grid">
                @if($tripData->hotel_1)
                <div class="info-item">
                    <div class="info-label">Hotel 1</div>
                    <div class="info-value">{{ $tripData->hotel_1 }}</div>
                </div>
                @endif
                @if($tripData->hotel_2)
                <div class="info-item">
                    <div class="info-label">Hotel 2</div>
                    <div class="info-value">{{ $tripData->hotel_2 }}</div>
                </div>
                @endif
                @if($tripData->hotel_3)
                <div class="info-item">
                    <div class="info-label">Hotel 3</div>
                    <div class="info-value">{{ $tripData->hotel_3 }}</div>
                </div>
                @endif
                @if($tripData->hotel_4)
                <div class="info-item">
                    <div class="info-label">Hotel 4</div>
                    <div class="info-value">{{ $tripData->hotel_4 }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="section">
            <div class="section-title">Informasi Keuangan</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Harga Total</div>
                    <div class="info-value">Rp {{ number_format($tripData->harga, 0, ',', '.') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Deposit</div>
                    <div class="info-value">Rp {{ number_format($tripData->deposit, 0, ',', '.') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Pelunasan</div>
                    <div class="info-value">Rp {{ number_format($tripData->pelunasan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        @if($tripData->tiba || $tripData->flight_balik)
        <div class="section">
            <div class="section-title">Informasi Tambahan</div>
            <div class="info-grid">
                @if($tripData->tiba)
                <div class="info-item">
                    <div class="info-label">Tanggal Tiba</div>
                    <div class="info-value">{{ $tripData->tiba->format('d F Y') }}</div>
                </div>
                @endif
                @if($tripData->flight_balik)
                <div class="info-item">
                    <div class="info-label">Flight Balik</div>
                    <div class="info-value">{{ $tripData->flight_balik }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($tripData->notes)
        <div class="section">
            <div class="section-title">Catatan</div>
            <div class="info-item full-width">
                <div class="info-value">{{ $tripData->notes }}</div>
            </div>
        </div>
        @endif

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
            <p class="no-print">
                <button onclick="window.print()" style="padding: 10px 20px; background: #FF4433; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">
                    Cetak / Download PDF
                </button>
            </p>
        </div>
    </div>
</body>
</html>
