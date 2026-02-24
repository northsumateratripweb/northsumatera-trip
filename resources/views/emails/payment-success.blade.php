<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil</title>
</head>
<body style="font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif; background: #f8fafc; color: #1e293b; margin:0; padding:40px 20px;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border:1px solid #f1f5f9; border-radius:32px; overflow:hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.05);">
        <div style="background: #1d4ed8; padding:48px 40px; text-align: center;">
            <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <h1 style="margin:0; font-size:24px; font-weight: 900; color:#ffffff; text-transform: uppercase; letter-spacing: 0.1em;">Pembayaran Berhasil</h1>
        </div>
        <div style="padding:48px 40px;">
            <p style="margin-top: 0; font-size: 16px; font-weight: 700; color: #1e293b;">Halo {{ $booking->customer_name }},</p>
            <p style="font-size: 15px; line-height: 1.6; color: #64748b;">Kabar baik! Pembayaran Anda telah kami terima dengan sukses. Petualangan Anda di Sumatera Utara selangkah lagi dimulai.</p>
            
            <div style="background: #f8fafc; border-radius: 24px; padding: 32px; margin: 32px 0;">
                <p style="margin-top: 0; font-size: 12px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.2em; margin-bottom: 20px;">Detail Pemesanan</p>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b;">Paket Wisata</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700; text-align: right;">{{ $tour->title ?? 'Paket Wisata' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b;">Tanggal Trip</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700; text-align: right;">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #64748b;">Jumlah Peserta</td>
                        <td style="padding: 8px 0; font-size: 14px; color: #1e293b; font-weight: 700; text-align: right;">{{ $booking->qty }} Orang</td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 0 0 0; font-size: 14px; color: #64748b; border-top: 1px solid #e2e8f0; margin-top: 16px;">Total Pembayaran</td>
                        <td style="padding: 16px 0 0 0; font-size: 18px; color: #1d4ed8; font-weight: 900; text-align: right; border-top: 1px solid #e2e8f0; margin-top: 16px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center;">
                <p style="font-size: 14px; color: #64748b; margin-bottom: 24px;">Unduh invoice Anda melalui tombol di bawah ini sebagai bukti pembayaran yang sah.</p>
                <a href="{{ route('invoice.pdf', $booking) }}" style="display: inline-block; background:#1d4ed8; color:#ffffff; padding:20px 40px; border-radius:20px; text-decoration:none; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; box-shadow: 0 10px 20px rgba(29, 78, 216, 0.2);">Unduh Invoice PDF</a>
            </div>

            <p style="margin-top: 48px; font-size: 14px; color: #64748b; text-align: center; line-height: 1.6;">Terima kasih telah memilih kami untuk menemani perjalanan Anda.<br>Sampai jumpa di Sumatera Utara!</p>
        </div>
        <div style="background:#f8fafc; padding:32px 40px; text-align: center; border-top: 1px solid #f1f5f9;">
            <p style="margin: 0; font-size:11px; font-weight: 700; color:#94a3b8; text-transform: uppercase; letter-spacing: 0.1em;">&copy; {{ date('Y') }} North Sumatera Trip. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
