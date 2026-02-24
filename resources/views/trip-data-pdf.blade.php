<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Report - {{ $tripData->nama_pelanggan }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 10px;
            background: #fff;
        }

        /* ── HEADER BAND ─────────────────────────────────── */
        .header {
            background: #1d4ed8;
            padding: 28px 36px 22px;
            color: #fff;
        }
        .header-inner {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }
        .brand-name {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -1px;
            color: #fff;
        }
        .brand-sub {
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }
        .doc-type {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
        }
        .doc-number {
            font-size: 22px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .doc-date {
            font-size: 9px;
            color: rgba(255,255,255,0.6);
            margin-top: 3px;
        }

        /* ── STATUS BAND ─────────────────────────────────── */
        .status-band {
            background: #eff6ff;
            border-bottom: 3px solid #bfdbfe;
            padding: 10px 36px;
            display: table;
            width: 100%;
        }
        .status-item {
            display: table-cell;
            padding-right: 20px;
            vertical-align: middle;
        }
        .status-label {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 2px;
        }
        .status-value {
            font-size: 11px;
            font-weight: 800;
            color: #1e293b;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .badge-blue   { background: #dbeafe; color: #1d4ed8; }
        .badge-green  { background: #d1fae5; color: #065f46; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-red    { background: #fee2e2; color: #991b1b; }

        /* ── BODY ─────────────────────────────────────────── */
        .body-wrap {
            padding: 24px 36px;
        }

        /* ── SECTION ─────────────────────────────────────── */
        .section { margin-bottom: 18px; }
        .section-header {
            font-size: 7.5px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1d4ed8;
            border-bottom: 1.5px solid #dbeafe;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        /* ── INFO GRID ───────────────────────────────────── */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .info-grid td {
            vertical-align: top;
            padding: 6px 14px 6px 0;
        }
        .info-label {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
        }
        .info-sub {
            font-size: 9px;
            color: #64748b;
            margin-top: 1px;
        }

        /* ── SERVICE TABLE ───────────────────────────────── */
        .service-table {
            width: 100%;
            border-collapse: collapse;
        }
        .service-table thead th {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            font-weight: 700;
            padding: 6px 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .service-table tbody td {
            padding: 8px 10px;
            border: 1px solid #f1f5f9;
            vertical-align: top;
            font-size: 9.5px;
            color: #334155;
        }
        .service-table tbody tr:nth-child(odd) td {
            background: #f8fafc;
        }

        /* ── BOTTOM SPLIT ────────────────────────────────── */
        .bottom-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .bottom-grid td {
            vertical-align: top;
        }
        .notes-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 9.5px;
            color: #475569;
            line-height: 1.5;
        }

        /* ── PAYMENT SUMMARY ─────────────────────────────── */
        .payment-box {
            background: #1e293b;
            border-radius: 8px;
            padding: 14px 16px;
            color: #fff;
        }
        .pay-row {
            width: 100%;
            border-collapse: collapse;
        }
        .pay-row td {
            padding: 4px 0;
            font-size: 10px;
            color: rgba(255,255,255,0.7);
        }
        .pay-row td:last-child {
            text-align: right;
            color: #fff;
            font-weight: 700;
        }
        .pay-row .deposit td { color: #34d399; }
        .pay-row .deposit td:last-child { color: #34d399; }
        .pay-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 8px 0;
        }
        .pay-total td {
            font-size: 13px !important;
            font-weight: 800 !important;
            color: #fff !important;
            padding-top: 6px !important;
        }
        .pay-total td:last-child { color: #60a5fa !important; }

        /* ── FOOTER ──────────────────────────────────────── */
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1.5px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer strong { color: #64748b; }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <table class="header-inner">
            <tr>
                <td class="header-left">
                    <div class="brand-name">{{ \App\Models\Setting::firstOrCreateDefault()->company_name }}</div>
                    <div class="brand-sub">North Sumatera Trip Organizer</div>
                </td>
                <td class="header-right">
                    <div class="doc-type">Trip Report</div>
                    <div class="doc-number">#TRIP-{{ str_pad($tripData->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="doc-date">Diterbitkan: {{ now()->format('d F Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── STATUS BAND ── --}}
    <div class="status-band">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td class="status-item">
                    <div class="status-label">Pelanggan</div>
                    <div class="status-value">{{ $tripData->nama_pelanggan }}</div>
                </td>
                <td class="status-item">
                    <div class="status-label">Tanggal Trip</div>
                    <div class="status-value">{{ $tripData->tanggal->format('d M Y') }}</div>
                </td>
                <td class="status-item">
                    <div class="status-label">Durasi</div>
                    <div class="status-value">{{ $tripData->jumlah_hari }} Hari / {{ $tripData->penumpang }} Pax</div>
                </td>
                <td class="status-item">
                    <div class="status-label">Layanan</div>
                    <div class="status-value">{{ $tripData->layanan }}</div>
                </td>
                <td style="text-align:right; vertical-align:middle; padding-left:10px;">
                    @php
                        $st = $tripData->status;
                        $bc = match($st) {
                            'Sudah Booking'  => 'badge-blue',
                            'Sedang Berjalan'=> 'badge-yellow',
                            'Selesai'        => 'badge-green',
                            default          => 'badge-red',
                        };
                    @endphp
                    <span class="badge {{ $bc }}">{{ $st }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── BODY ── --}}
    <div class="body-wrap">

        {{-- Customer & Contact --}}
        <div class="section">
            <div class="section-header">Informasi Pelanggan</div>
            <table class="info-grid">
                <tr>
                    <td width="25%">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $tripData->nama_pelanggan }}</div>
                    </td>
                    <td width="25%">
                        <div class="info-label">Nomor HP</div>
                        <div class="info-value">{{ $tripData->nomor_hp }}</div>
                    </td>
                    <td width="25%">
                        <div class="info-label">Tanggal Tiba</div>
                        <div class="info-value">{{ $tripData->tiba ? $tripData->tiba->format('d M Y') : '-' }}</div>
                    </td>
                    <td width="25%">
                        <div class="info-label">Flight Balik</div>
                        <div class="info-value">{{ $tripData->flight_balik ?: '-' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Service & Vehicle --}}
        <div class="section">
            <div class="section-header">Detail Layanan & Kendaraan</div>
            <table class="service-table">
                <thead>
                    <tr>
                        <th style="text-align:left; width:22%;">Layanan</th>
                        <th style="text-align:left; width:20%;">Driver</th>
                        <th style="text-align:left; width:20%;">Kendaraan</th>
                        <th style="text-align:left; width:18%;">Plat Nomor</th>
                        <th style="text-align:center; width:10%;">Drone</th>
                        <th style="text-align:center; width:10%;">Penumpang</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight:700; color:#1d4ed8;">{{ $tripData->layanan }}</td>
                        <td>{{ $tripData->nama_driver ?: '—' }}</td>
                        <td>{{ $tripData->jenis_mobil ?: '—' }}</td>
                        <td>{{ $tripData->plat_mobil ?: '—' }}</td>
                        <td style="text-align:center;">
                            @if($tripData->drone)
                                <span class="badge badge-blue">Ya</span>
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td style="text-align:center; font-weight:700;">{{ $tripData->penumpang }} Pax</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Accommodations --}}
        @if($tripData->hotel_1 || $tripData->hotel_2 || $tripData->hotel_3 || $tripData->hotel_4)
        <div class="section">
            <div class="section-header">Akomodasi</div>
            <table class="service-table">
                <thead>
                    <tr>
                        @if($tripData->hotel_1) <th style="text-align:left;">Hotel / Malam 1</th> @endif
                        @if($tripData->hotel_2) <th style="text-align:left;">Hotel / Malam 2</th> @endif
                        @if($tripData->hotel_3) <th style="text-align:left;">Hotel / Malam 3</th> @endif
                        @if($tripData->hotel_4) <th style="text-align:left;">Hotel / Malam 4</th> @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if($tripData->hotel_1) <td style="font-weight:600;">{{ $tripData->hotel_1 }}</td> @endif
                        @if($tripData->hotel_2) <td style="font-weight:600;">{{ $tripData->hotel_2 }}</td> @endif
                        @if($tripData->hotel_3) <td style="font-weight:600;">{{ $tripData->hotel_3 }}</td> @endif
                        @if($tripData->hotel_4) <td style="font-weight:600;">{{ $tripData->hotel_4 }}</td> @endif
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        {{-- Notes + Payment --}}
        <table class="bottom-grid">
            <tr>
                <td width="52%" style="padding-right:16px; vertical-align:top;">
                    <div class="section-header">Catatan</div>
                    <div class="notes-box">
                        {{ $tripData->notes ?: 'Tidak ada catatan khusus untuk perjalanan ini.' }}
                    </div>
                </td>
                <td width="48%" style="vertical-align:top;">
                    <div class="section-header">Ringkasan Pembayaran</div>
                    <div class="payment-box">
                        <table class="pay-row">
                            <tr>
                                <td>Harga Paket</td>
                                <td>Rp {{ number_format($tripData->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="deposit">
                                <td>Deposit Terbayar</td>
                                <td>− Rp {{ number_format($tripData->deposit, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        <hr class="pay-divider">
                        <table class="pay-row pay-total">
                            <tr>
                                <td>Sisa Pelunasan</td>
                                <td>Rp {{ number_format($tripData->pelunasan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Footer --}}
        <div class="footer">
            <strong>{{ \App\Models\Setting::firstOrCreateDefault()->company_name }}</strong> &bull;
            Dokumen ini dicetak otomatis pada {{ now()->format('d F Y, H:i') }} WIB<br>
            Untuk pertanyaan mengenai dokumen ini, silakan hubungi kami via WhatsApp dengan mencantumkan nomor ID di atas.
        </div>

    </div>

</body>
</html>