<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\TripData;
use App\Services\WhatsAppService;
use App\Jobs\SendPendingPaymentReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CarBookingController extends Controller
{
    public function checkout(Request $request, $id)
    {
        // Honeypot check
        if ($request->filled('hp_field')) {
            return response()->json(['message' => 'Spam detected'], 403);
        }

        $car = Car::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'travel_date' => 'required|date|after_or_equal:today',
                'duration' => 'required|integer|min:1',
            ]);
        }

        $orderId = $request->order_id ?? ('CAR-'.uniqid());
        $duration = $request->duration ?? 1;
        $grossAmount = $car->price_per_day * $duration;

        try {
            $booking = null;
            if ($request->action === 'payment' && $request->order_id) {
                $booking = Booking::where('external_id', $request->order_id)->first();
            }

            if (!$booking) {
                $booking = Booking::create([
                    'user_id'          => auth()->id(),
                    'booking_type'     => 'car',
                    'car_id'           => $car->id,
                    'customer_name'    => $request->customer_name ?? 'Customer',
                    'customer_whatsapp'=> $request->customer_whatsapp ?? $request->phone ?? '08000000000',
                    'phone'            => $request->phone ?? '08000000000',
                    'travel_date'      => $request->travel_date ?? now()->format('Y-m-d'),
                    'qty'              => 1,
                    'duration_days'    => $duration,
                    'total_price'      => $grossAmount,
                    'status'           => 'pending',
                    'payment_status'   => 'pending',
                    'external_id'      => $orderId,
                ]);

                TripData::create([
                    'booking_id'    => $booking->id,
                    'tanggal'       => $booking->travel_date,
                    'nama_pelanggan'=> $booking->customer_name,
                    'status'        => 'Sudah Booking',
                    'nomor_hp'      => $booking->customer_whatsapp ?? $booking->phone,
                    'layanan'       => 'Rent Car',
                    'jenis_mobil'   => $car->name ?? null,
                    'jumlah_hari'   => $duration,
                    'penumpang'     => $car->capacity ?? 0,
                    'harga'         => $booking->total_price,
                    'notes'         => 'Booking rental: ' . ($booking->external_id ?? $booking->id)
                                     . ' | ' . ($car->brand ?? '') . ' ' . ($car->name ?? ''),
                ]);
            }

            if ($request->action === 'create') {
                return response()->json([
                    'success' => true,
                    'order_id' => $booking->external_id,
                    'message' => 'Booking rental mobil berhasil disimpan'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Car booking processing failed: '.$e->getMessage());
            return response()->json(['error' => 'Gagal memproses sewa mobil: '.$e->getMessage()], 500);
        }

        // WhatsApp Notification & Manual Payment Instructions
        $bankDetails = \App\Helpers\SettingsHelper::bankDetails();
        $waNumber = preg_replace('/\D/', '', \App\Helpers\SettingsHelper::whatsappNumber());

        $waMessage = "✨ *BOOKING SEWA MOBIL BERHASIL* ✨\n\n";
        $waMessage .= "Halo *" . $booking->customer_name . "*,\n";
        $waMessage .= "Terima kasih telah memilih jasa rental kami! Pesanan sewa mobil Anda telah kami terima.\n\n";
        $waMessage .= "📋 *DETAIL SEWA:*\n";
        $waMessage .= "• *ID Pesanan:* " . $booking->external_id . "\n";
        $waMessage .= "• *Unit:* " . $car->name . "\n";
        $waMessage .= "• *Tanggal Mulai:* " . \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') . "\n";
        $waMessage .= "• *Durasi:* " . $booking->duration_days . " Hari\n";
        $waMessage .= "• *Total Bayar:* Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n";
        
        $waMessage .= "💳 *PEMBAYARAN MANUAL:*\n";
        $waMessage .= "Silakan transfer ke salah satu rekening berikut:\n\n";
        $waMessage .= "🏦 *" . $bankDetails['bank_1']['name'] . "*\n";
        $waMessage .= "No. Rek: *" . $bankDetails['bank_1']['account'] . "*\n";
        $waMessage .= "A/N: " . $bankDetails['bank_1']['holder'] . "\n\n";
        $waMessage .= "🏦 *" . $bankDetails['bank_2']['name'] . "*\n";
        $waMessage .= "No. Rek: *" . $bankDetails['bank_2']['account'] . "*\n";
        $waMessage .= "A/N: " . $bankDetails['bank_2']['holder'] . "\n\n";
        
        $waMessage .= "📱 *KONFIRMASI:*\n";
        $waMessage .= "Setelah transfer, mohon kirimkan bukti pembayaran ke nomor ini.\n\n";
        $waMessage .= "Cek status pesanan Anda di:\n";
        $waMessage .= route('booking.status') . "?order_id=" . $booking->external_id . "\n\n";
        $waMessage .= "--- \n";
        $waMessage .= "Unit akan disiapkan setelah pembayaran dikonfirmasi. Terima kasih! 🙏";

        WhatsAppService::sendMessage($booking->phone, $waMessage);

        // Optional: Dispatch reminder job if needed
        // SendPendingPaymentReminder::dispatch($booking->id)->delay(now()->addDay());

        if ($request->expectsJson() || $request->action === 'payment') {
            return response()->json([
                'success' => true,
                'order_id' => $booking->external_id,
                'gross_amount' => $booking->total_price,
            ]);
        }

        return redirect()->route('booking.status', ['order_id' => $booking->external_id]);
    }
}
