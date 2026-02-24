@php
    use Illuminate\Support\Carbon;
    use App\Helpers\SettingsHelper;

    $isItinerary = !isset($booking) || is_null($booking);
    $bookingTour = $isItinerary ? null : $booking->tour;
    $bookingCar  = $isItinerary ? null : $booking->car;

    // ── Resolve item details ─────────────────────────────────
    if ($isItinerary) {
        $itemName   = $tour->title ?? 'Paket Wisata';
        $itemMeta   = ($tour->duration_days ?? '—') . ' Hari • ' . ($tour->location ?? '—');
        $itemPrice  = $tour->price ?? 0;
        $itemQty    = 1;
        $totalPrice = $itemPrice;
        $droneFee   = 0;
        $subtotal   = $itemPrice;
    } elseif ($bookingCar) {
        $itemName   = $bookingCar->name ?? 'Sewa Kendaraan';
        $brand      = $bookingCar->brand ?? '';
        $itemMeta   = trim("Rental Mobil • {$brand} {$bookingCar->name}");
        $itemPrice  = $bookingCar->price_per_day ?? 0;
        $itemQty    = $booking->duration_days ?? 1;
        $totalPrice = $booking->total_price;
        $droneFee   = 0;
        $subtotal   = $totalPrice;
    } else {
        $itemName   = $bookingTour->title ?? 'Paket Wisata';
        $itemMeta   = ($bookingTour->duration_days ?? '—') . ' Hari • ' . ($bookingTour->location ?? '—');
        $droneFee   = ($booking->use_drone ?? false) ? 250000 : 0;
        $totalPrice = $booking->total_price;
        $subtotal   = $totalPrice - $droneFee;
        $itemQty    = $booking->qty ?? 1;
        $itemPrice  = $itemQty > 0 ? round($subtotal / $itemQty) : $subtotal;
    }

    // ── Trip type vars passed from controller ────────────────
    $tripLabel    = $tripTypeLabel    ?? null;
    $tripName     = $tripTypeName     ?? null;
    $tripIncludes = $tripTypeIncludes ?? null;
    $useDrone     = !$isItinerary && ($booking->use_drone ?? false);

    // ── Company settings ─────────────────────────────────────
    $companyName  = SettingsHelper::companyName();
    $primaryColor = SettingsHelper::primaryColor() ?: '#1d4ed8';
    $waNumber     = SettingsHelper::whatsappNumber();
    $emailContact = SettingsHelper::email();

    // ── Status helpers ───────────────────────────────────────
    if (!$isItinerary) {
        $ps = $booking->payment_status ?? 'pending';
        $psLabel = match($ps) {
            'paid'    => '✓ LUNAS',
            'pending' => '⏳ MENUNGGU',
            default   => '✗ BELUM BAYAR',
        };
        $psBadge = match($ps) {
            'paid'    => '#dcfce7|#166534',
            'pending' => '#fef9c3|#854d0e',
            default   => '#fee2e2|#991b1b',
        };
        [$psBg, $psFg] = explode('|', $psBadge);

        $os = $booking->status ?? 'pending';
        $osLabel = strtoupper($os);
        $osBadge = match($os) {
            'confirmed', 'success' => '#dbeafe|#1e40af',
            'cancelled', 'failed'  => '#fee2e2|#991b1b',
            default                => '#fef9c3|#854d0e',
        };
        [$osBg, $osFg] = explode('|', $osBadge);

        $invoiceNo = $booking->external_id ?? 'NST-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $issuedAt  = $booking->created_at->format('d F Y');
        $bookingType = ucfirst($booking->booking_type ?? 'online');
    } else {
        $invoiceNo = '#PREVIEW';
        $issuedAt  = now()->format('d F Y');
        $bookingType = '—';
        $ps = null; $os = null;
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $isItinerary ? 'Itinerary' : 'Invoice' }} – {{ $itemName }}</title>
    <style>
        @page { size: A4; margin: 0; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            background: #fff;
            line-height: 1.5;
        }

        /* ══ HEADER ═══════════════════════════════════════════ */
        .hdr { background: {{ $primaryColor }}; padding: 36px 50px 28px; color:#fff; position:relative; overflow:hidden; }
        .hdr::before {
            content:''; position:absolute; top:-60px; right:-60px;
            width:220px; height:220px; background:rgba(255,255,255,.06); border-radius:50%;
        }
        .hdr-t  { display:table; width:100%; }
        .hdr-l  { display:table-cell; vertical-align:middle; }
        .hdr-r  { display:table-cell; vertical-align:middle; text-align:right; }
        .brand  { font-size:26px; font-weight:900; letter-spacing:-1px; color:#fff; }
        .brand-sub { font-size:9px; letter-spacing:3px; text-transform:uppercase; color:rgba(255,255,255,.6); margin-top:3px; }
        .doc-type   { font-size:9px; font-weight:700; letter-spacing:4px; text-transform:uppercase; color:rgba(255,255,255,.7); }
        .doc-num    { font-size:22px; font-weight:900; color:#fff; letter-spacing:-0.5px; margin-top:4px; }

        /* ══ META BAR ═════════════════════════════════════════ */
        .meta { background:#f8fafc; border-bottom:2px solid #e2e8f0; padding:12px 50px; }
        .meta-t { display:table; width:100%; }
        .meta-c { display:table-cell; vertical-align:middle; padding-right:36px; }
        .meta-c:last-child { padding-right:0; text-align:right; }
        .ml { font-size:8px; text-transform:uppercase; letter-spacing:1.5px; color:#64748b; margin-bottom:2px; }
        .mv { font-size:11.5px; font-weight:800; color:#1e293b; }

        .badge {
            display:inline-block; padding:3px 12px; border-radius:50px;
            font-size:8.5px; font-weight:900; text-transform:uppercase; letter-spacing:.8px;
        }

        /* ══ BODY ═════════════════════════════════════════════ */
        .body { padding:32px 50px 0; }

        .sec-title {
            font-size:8.5px; font-weight:800; letter-spacing:2px;
            text-transform:uppercase; color:{{ $primaryColor }};
            padding:0 0 7px 10px; margin-bottom:16px;
            border-bottom:1px solid #e2e8f0;
            border-left:3px solid {{ $primaryColor }};
        }

        /* ── Two-column info ─── */
        .grid2 { display:table; width:100%; margin-bottom:26px; }
        .col2   { display:table-cell; width:50%; vertical-align:top; }
        .col2-l { padding-right:18px; }
        .col2-r { padding-left:18px; border-left:1px solid #f1f5f9; }

        .dr  { margin-bottom:13px; }
        .dl  { font-size:8px; color:#94a3b8; text-transform:uppercase; letter-spacing:.9px; margin-bottom:2px; }
        .dv  { font-size:11.5px; font-weight:700; color:#1e293b; }
        .dv-a{ color:{{ $primaryColor }}; font-size:12.5px; }
        .dv-s{ font-size:10.5px; }

        /* ── Trip Detail card ─── */
        .tdc {
            background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:10px; padding:15px 18px; margin-bottom:24px;
        }
        .tdc-head { font-size:8px; font-weight:800; letter-spacing:2px; text-transform:uppercase; color:{{ $primaryColor }}; margin-bottom:12px; }
        .tdc-t { display:table; width:100%; }
        .tdc-c { display:table-cell; vertical-align:top; padding-right:20px; }
        .tdc-c:last-child { padding-right:0; }
        .tdc-type {
            font-size:18px; font-weight:900; color:#5b21b6;
            background:#ede9fe; display:inline-block;
            padding:4px 16px; border-radius:8px; letter-spacing:-0.5px;
        }

        /* ── Includes box ─── */
        .inc-box {
            background:#eff6ff; border:1px solid #bfdbfe;
            border-radius:8px; padding:13px 16px; margin-bottom:24px;
        }
        .inc-title { font-size:8.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#1d4ed8; margin-bottom:8px; }
        .inc-body  { font-size:10px; color:#1e40af; line-height:1.8; }

        /* ── Cost table ─── */
        .ct { width:100%; border-collapse:collapse; margin-bottom:26px; }
        .ct th {
            background:#1e293b; color:#fff; padding:10px 13px;
            font-size:8.5px; text-transform:uppercase; letter-spacing:.8px;
            text-align:left;
        }
        .ct th.r { text-align:right; }
        .ct th.c { text-align:center; }
        .ct td   { padding:13px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
        .ct tr:last-child td { border-bottom:none; }
        .ct tr:nth-child(even) td { background:#fafafa; }
        .i-name { font-weight:800; font-size:13px; color:#0f172a; }
        .i-desc { font-size:9px; color:#64748b; margin-top:3px; text-transform:uppercase; letter-spacing:.5px; }
        .tag {
            display:inline-block; padding:2px 9px; border-radius:4px;
            font-size:8px; font-weight:800; text-transform:uppercase; letter-spacing:.5px; margin-top:5px;
        }
        .tag-trip  { background:#ede9fe; color:#5b21b6; }
        .tag-drone { background:#fef3c7; color:#92400e; }
        .tag-car   { background:#dcfce7; color:#166534; }
        .tag-tour  { background:#dbeafe; color:#1e40af; }

        /* ── Summary ─── */
        .sw  { display:table; width:100%; margin-bottom:30px; }
        .sn  { display:table-cell; width:52%; vertical-align:bottom; padding-right:18px; }
        .snb { background:#f8fafc; border:1px solid #e2e8f0; border-radius:9px; padding:14px 16px; }
        .snb-h { font-size:8.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#475569; margin-bottom:8px; }
        .snb-p { font-size:9.5px; color:#64748b; line-height:1.9; }
        .sb  { display:table-cell; width:48%; background:#0f172a; border-radius:12px; padding:22px; color:#fff; vertical-align:top; }
        .sr  { display:table; width:100%; margin-bottom:8px; }
        .sl2 { display:table-cell; font-size:10px; color:#94a3b8; }
        .sv2 { display:table-cell; text-align:right; font-weight:700; font-size:11px; color:#e2e8f0; }
        .sdiv{ border-top:1px solid rgba(255,255,255,.1); margin:12px 0; }
        .str { display:table; width:100%; }
        .stl { display:table-cell; font-size:11px; font-weight:800; color:#fff; text-transform:uppercase; letter-spacing:1px; vertical-align:middle; }
        .stv { display:table-cell; text-align:right; font-size:21px; font-weight:900; color:#60a5fa; vertical-align:middle; }

        /* ── Footer ─── */
        .ftr {
            text-align:center; padding:24px 50px 28px;
            border-top:2px solid #f1f5f9; background:#fafafa;
        }
        .ftr-h  { font-size:13px; font-weight:900; color:#0f172a; margin-bottom:5px; }
        .ftr-s  { font-size:9.5px; color:#94a3b8; max-width:400px; margin:0 auto 14px; }
        .ftr-ct { display:inline-table; }
        .ftr-ci { display:table-cell; padding:0 14px; font-size:10px; font-weight:700; color:#475569; }
        .ftr-sep{ display:table-cell; color:#cbd5e1; }
        .ftr-cp { font-size:8.5px; color:#cbd5e1; margin-top:10px; }

        @media print { .no-print { display:none !important; } }
    </style>
</head>
<body>

{{-- ══ HEADER ══════════════════════════════════════════════════ --}}
<div class="hdr">
    <table class="hdr-t">
        <tr>
            <td class="hdr-l">
                <div class="brand">{{ strtoupper($companyName) }}</div>
                <div class="brand-sub">Premium North Sumatera Travel &amp; Tour</div>
            </td>
            <td class="hdr-r">
                <div class="doc-type">{{ $isItinerary ? 'Itinerary Preview' : 'Official Invoice' }}</div>
                <div class="doc-num">{{ $invoiceNo }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ══ META BAR ════════════════════════════════════════════════ --}}
<div class="meta">
    <div class="meta-t">
        {{-- Tanggal Terbit --}}
        <div class="meta-c">
            <div class="ml">Tanggal Terbit</div>
            <div class="mv">{{ $issuedAt }}</div>
        </div>

        @if(!$isItinerary)
        {{-- ID Pemesanan --}}
        <div class="meta-c">
            <div class="ml">ID Pemesanan</div>
            <div class="mv">{{ $invoiceNo }}</div>
        </div>

        {{-- Status Pembayaran --}}
        <div class="meta-c">
            <div class="ml">Status Pembayaran</div>
            <div class="mv">
                <span class="badge" style="background:{{ $psBg }};color:{{ $psFg }};">{{ $psLabel }}</span>
            </div>
        </div>

        {{-- Status Pesanan --}}
        <div class="meta-c">
            <div class="ml">Status Pesanan</div>
            <div class="mv">
                <span class="badge" style="background:{{ $osBg }};color:{{ $osFg }};">{{ $osLabel }}</span>
            </div>
        </div>
        @endif

        {{-- Kategori --}}
        <div class="meta-c">
            <div class="ml">Kategori</div>
            <div class="mv">{{ $bookingCar ? '🚗 Rental Mobil' : '🏔️ Paket Wisata' }}</div>
        </div>
    </div>
</div>

{{-- ══ BODY ════════════════════════════════════════════════════ --}}
<div class="body">

    {{-- ── 1. INFORMASI PELANGGAN & PERJALANAN ─────────────── --}}
    <div class="sec-title">Informasi Pelanggan &amp; Perjalanan</div>
    <div class="grid2">
        {{-- Kolom Kiri: Pelanggan --}}
        <div class="col2 col2-l">
            <div class="dr">
                <div class="dl">Nama Pelanggan</div>
                <div class="dv dv-a">{{ $isItinerary ? 'Guest Customer' : $booking->customer_name }}</div>
            </div>
            <div class="dr">
                <div class="dl">WhatsApp / HP</div>
                <div class="dv">{{ $isItinerary ? $waNumber : ($booking->customer_whatsapp ?? $booking->phone ?? '—') }}</div>
            </div>
            <div class="dr">
                <div class="dl">Email</div>
                <div class="dv dv-s">{{ $isItinerary ? $emailContact : ($booking->email ?? '—') }}</div>
            </div>
            @if(!$isItinerary)
            <div class="dr">
                <div class="dl">Tipe Pemesanan</div>
                <div class="dv">{{ $bookingType }}</div>
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Detail Perjalanan --}}
        <div class="col2 col2-r">
            <div class="dr">
                <div class="dl">Tanggal {{ $bookingCar ? 'Mulai Sewa' : 'Keberangkatan' }}</div>
                <div class="dv dv-a">
                    @if($isItinerary)
                        Berdasarkan Request
                    @else
                        {{ Carbon::parse($booking->travel_date)->translatedFormat('l, d F Y') }}
                    @endif
                </div>
            </div>

            @if($bookingTour)
            <div class="dr">
                <div class="dl">Durasi Perjalanan</div>
                <div class="dv">{{ $bookingTour->duration_days }} Hari {{ ($bookingTour->duration_days - 1) }} Malam</div>
            </div>
            @endif

            <div class="dr">
                <div class="dl">{{ $bookingCar ? 'Lama Sewa' : 'Jumlah Peserta' }}</div>
                <div class="dv">
                    @if($isItinerary)
                        {{ ($tour->duration_days ?? '—') }} Hari
                    @elseif($bookingCar)
                        {{ $booking->duration_days ?? 1 }} Hari
                    @else
                        {{ $booking->qty }} Orang
                    @endif
                </div>
            </div>

            @if(!$isItinerary && $bookingTour && $bookingTour->location)
            <div class="dr">
                <div class="dl">Lokasi Destinasi</div>
                <div class="dv">📍 {{ $bookingTour->location }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- ── 2. CARD DETAIL LAYANAN ───────────────────────────── --}}
    @if(!$isItinerary && ($tripLabel || $useDrone || $bookingCar))
    <div class="tdc">
        <div class="tdc-head">Detail Layanan yang Dipilih</div>
        <div class="tdc-t">
            @if($tripLabel)
            <div class="tdc-c">
                <div class="dl">Tipe Trip / Paket</div>
                <div class="tdc-type">{{ $tripLabel }}</div>
                @if($tripName)
                <div style="font-size:10px;color:#6d28d9;margin-top:4px;">{{ $tripName }}</div>
                @endif
            </div>
            @endif

            <div class="tdc-c">
                <div class="dl">Layanan Drone</div>
                <div class="dv" style="{{ $useDrone ? 'color:#92400e;' : 'color:#94a3b8;' }}">
                    {{ $useDrone ? '🚁 Ya – Dokumentasi Drone' : 'Tidak' }}
                </div>
            </div>

            <div class="tdc-c">
                <div class="dl">Tipe Booking</div>
                <div class="dv">{{ $bookingType }}</div>
            </div>

            @if($bookingCar && $bookingCar->brand)
            <div class="tdc-c">
                <div class="dl">Kendaraan</div>
                <div class="dv">{{ $bookingCar->brand }} {{ $bookingCar->name }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ── 3. YANG TERMASUK DALAM PAKET ────────────────────── --}}
    @if($tripIncludes)
    <div class="inc-box">
        <div class="inc-title">✅ Yang Sudah Termasuk dalam Paket {{ $tripLabel }}</div>
        <div class="inc-body">{{ $tripIncludes }}</div>
    </div>
    @endif

    {{-- ── 4. TABEL RINCIAN BIAYA ───────────────────────────── --}}
    <div class="sec-title">Rincian Biaya</div>
    <table class="ct">
        <thead>
            <tr>
                <th width="44%">Deskripsi Layanan</th>
                <th width="14%" class="r">Harga Satuan</th>
                <th width="10%" class="c">{{ $bookingCar ? 'Hari' : 'Orang' }}</th>
                <th width="12%" class="c">Tipe</th>
                <th width="20%" class="r">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Baris utama: Paket / Rental --}}
            <tr>
                <td>
                    <div class="i-name">{{ $itemName }}</div>
                    <div class="i-desc">{{ $itemMeta }}</div>
                    @if($tripLabel)
                        <span class="tag tag-trip">Trip: {{ $tripLabel }}</span>
                    @elseif($bookingCar)
                        <span class="tag tag-car">Rental Mobil</span>
                    @else
                        <span class="tag tag-tour">Paket Wisata</span>
                    @endif
                </td>
                <td style="text-align:right;font-weight:700;">
                    Rp {{ number_format($itemPrice, 0, ',', '.') }}
                </td>
                <td style="text-align:center;font-weight:700;">
                    {{ $itemQty }}
                </td>
                <td style="text-align:center;">
                    @if($tripLabel)
                        <span class="tag tag-trip">{{ $tripLabel }}</span>
                    @elseif($bookingCar)
                        <span class="tag tag-car">Rental</span>
                    @else
                        <span class="tag tag-tour">Tour</span>
                    @endif
                </td>
                <td style="text-align:right;font-weight:800;color:{{ $primaryColor }};">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </td>
            </tr>

            {{-- Baris drone (jika ada) --}}
            @if($useDrone)
            <tr>
                <td>
                    <div class="i-name">Layanan Dokumentasi Drone</div>
                    <div class="i-desc">Foto &amp; Video Aerial Profesional selama perjalanan</div>
                    <span class="tag tag-drone">🚁 Add-on</span>
                </td>
                <td style="text-align:right;font-weight:700;">
                    Rp {{ number_format($droneFee, 0, ',', '.') }}
                </td>
                <td style="text-align:center;font-weight:700;">1</td>
                <td style="text-align:center;"><span class="tag tag-drone">Drone</span></td>
                <td style="text-align:right;font-weight:800;color:#92400e;">
                    Rp {{ number_format($droneFee, 0, ',', '.') }}
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- ── 5. RINGKASAN PEMBAYARAN ──────────────────────────── --}}
    <div class="sw">
        {{-- Kiri: Catatan --}}
        <div class="sn">
            <div class="snb">
                <div class="snb-h">📋 Catatan Penting</div>
                <div class="snb-p">
                    • Harga di atas adalah harga final sesuai paket yang dipilih.<br>
                    • Dokumen ini merupakan bukti resmi pemesanan yang sah.<br>
                    @if(!$isItinerary && ($booking->payment_status ?? '') !== 'paid')
                    • Harap selesaikan pembayaran sebelum tanggal keberangkatan.<br>
                    • Hubungi kami via WhatsApp jika ada pertanyaan pembayaran.<br>
                    @endif
                    • Pastikan data peserta sesuai dokumen identitas resmi.<br>
                    • Dokumen diterbitkan elektronik, sah tanpa tanda tangan basah.
                </div>
            </div>
        </div>

        {{-- Kanan: Kotak total --}}
        <div class="sb">
            @if($useDrone)
            <div class="sr">
                <div class="sl2">Harga Paket</div>
                <div class="sv2">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
            </div>
            <div class="sr">
                <div class="sl2">Layanan Drone</div>
                <div class="sv2" style="color:#fcd34d;">+ Rp {{ number_format($droneFee, 0, ',', '.') }}</div>
            </div>
            @else
            <div class="sr">
                <div class="sl2">Subtotal</div>
                <div class="sv2">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
            </div>
            @endif
            <div class="sr">
                <div class="sl2">Pajak / Biaya Layanan</div>
                <div class="sv2">Rp 0</div>
            </div>
            <div class="sdiv"></div>
            <div class="str">
                <div class="stl">Total Tagihan</div>
                <div class="stv">Rp {{ number_format($isItinerary ? $itemPrice : $totalPrice, 0, ',', '.') }}</div>
            </div>
            @if(!$isItinerary && ($booking->payment_status ?? '') === 'paid')
            <div style="text-align:right;margin-top:10px;">
                <span class="badge" style="background:#dcfce7;color:#166534;font-size:9px;">✓ SUDAH LUNAS</span>
            </div>
            @endif
        </div>
    </div>

</div>{{-- /body --}}

{{-- ══ FOOTER ══════════════════════════════════════════════════ --}}
<div class="ftr">
    <div class="ftr-h">Terima kasih telah memilih {{ $companyName }}! 🙏</div>
    <div class="ftr-s">
        Kami berkomitmen memberikan pengalaman perjalanan terbaik di Sumatera Utara.
        Jangan ragu menghubungi kami jika ada pertanyaan atau bantuan.
    </div>
    <div class="ftr-ct">
        <div class="ftr-ci">📱 {{ $waNumber }}</div>
        <div class="ftr-sep">•</div>
        <div class="ftr-ci">✉️ {{ $emailContact }}</div>
        <div class="ftr-sep">•</div>
        <div class="ftr-ci">🌐 {{ request()->getHttpHost() }}</div>
    </div>
    <div class="ftr-cp">
        Invoice ini diterbitkan secara digital dan sah tanpa tanda tangan basah.
        &copy; {{ date('Y') }} {{ $companyName }} — All rights reserved.
    </div>
</div>

</body>
</html>
