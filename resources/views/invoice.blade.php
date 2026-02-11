@php
    use App\Helpers\SettingsHelper;
    $setting = SettingsHelper::get();
    $tour = \App\Models\Tour::find($booking->tour_id);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $booking->external_id ?? 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid {{ SettingsHelper::primaryColor() }};
        }
        .company-info h1 {
            color: {{ SettingsHelper::primaryColor() }};
            font-size: 32px;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 18px;
            color: #666;
            font-weight: bold;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .invoice-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eee;
        }
        .info-item {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            display: inline-block;
            width: 120px;
        }
        .info-value {
            color: #333;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: {{ SettingsHelper::primaryColor() }};
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .items-table tr:hover {
            background: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .total-final {
            font-size: 24px;
            font-weight: bold;
            color: {{ SettingsHelper::primaryColor() }};
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-success { background: #28a745; color: white; }
        .status-pending { background: #ffc107; color: #000; }
        .status-failed { background: #dc3545; color: white; }
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-primary {
            background: {{ SettingsHelper::primaryColor() }};
            color: white;
        }
        .btn-primary:hover {
            background: {{ SettingsHelper::secondaryColor() }};
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
            .action-buttons {
                display: none;
            }
            @page {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="company-info">
                <h1>{{ SettingsHelper::companyName() }}</h1>
                <div class="invoice-number">
                    Invoice #{{ $booking->external_id ?? 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <p style="margin-top: 10px; color: #666; font-size: 14px;">
                    Tanggal: {{ $booking->created_at->format('d F Y') }}
                </p>
            </div>
            <div class="invoice-details">
                @if($setting->logo)
                    <img src="{{ SettingsHelper::logo() }}" alt="Logo" style="max-height: 80px; margin-bottom: 10px;">
                @endif
                @if($setting->email)
                    <p><strong>Email:</strong> {{ $setting->email }}</p>
                @endif
                @if($setting->whatsapp_number)
                    <p><strong>WhatsApp:</strong> {{ $setting->whatsapp_number }}</p>
                @endif
            </div>
        </div>

        <div class="invoice-body">
            <div class="section">
                <div class="section-title">Informasi Pelanggan</div>
                <div class="info-item">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $booking->customer_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $booking->email ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value">{{ $booking->phone ?? $booking->customer_whatsapp }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">WhatsApp:</span>
                    <span class="info-value">{{ $booking->customer_whatsapp ?? '-' }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Detail Pemesanan</div>
                <div class="info-item">
                    <span class="info-label">Tanggal Trip:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jumlah:</span>
                    <span class="info-value">{{ $booking->qty }} orang</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-{{ $booking->payment_status === 'success' ? 'success' : ($booking->payment_status === 'pending' ? 'pending' : 'failed') }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        @if($tour)
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Lokasi</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $tour->title }}</strong><br>
                        <small style="color: #666;">Durasi: {{ $tour->duration_days }} hari</small>
                    </td>
                    <td>{{ $tour->location }}</td>
                    <td class="text-right">{{ $booking->qty }} orang</td>
                    <td class="text-right">Rp {{ number_format($tour->price, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endif

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Pajak:</span>
                <span>Rp 0</span>
            </div>
            <div class="total-row total-final">
                <span>Total Pembayaran:</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="invoice-footer">
            <p><strong>Terima kasih atas kepercayaan Anda!</strong></p>
            <p style="margin-top: 10px;">Invoice ini adalah bukti pembayaran yang sah untuk pemesanan Anda.</p>
            <p style="margin-top: 5px;">Jika ada pertanyaan, silakan hubungi kami melalui WhatsApp atau email.</p>
            
            <div class="action-buttons">
                <button onclick="window.print()" class="btn btn-primary">Cetak / Download PDF</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        // Auto print jika parameter print=1 ada di URL
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>
