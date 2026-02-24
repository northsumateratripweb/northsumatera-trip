<?php

namespace App\Jobs;

use App\Mail\BookingReminderMail;
use App\Models\Booking;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPendingPaymentReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $bookingId;

    public function __construct(int $bookingId)
    {
        $this->bookingId = $bookingId;
    }

    public function handle(): void
    {
        $booking = Booking::find($this->bookingId);
        if (! $booking) {
            return;
        }

        if ($booking->payment_status !== 'pending') {
            return;
        }

        if ($booking->email) {
            Mail::to($booking->email)->send(new BookingReminderMail($booking));
        }

        // Kirim WhatsApp Reminder
        $waMessage = "*PENGINGAT PEMBAYARAN* ⏰\n\n";
        $waMessage .= "Halo " . $booking->customer_name . ",\n";
        $waMessage .= "Kami melihat Anda memiliki pesanan *" . $booking->external_id . "* yang masih menunggu pembayaran.\n\n";
        $waMessage .= "*Detail:* " . ($booking->tour->title ?? 'Paket Wisata') . "\n";
        $waMessage .= "*Total:* Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n";
        $waMessage .= "Selesaikan pembayaran Anda melalui link ini:\n";
        $waMessage .= route('checkout', $booking->tour_id) . "?order_id=" . $booking->external_id . "\n\n";
        $waMessage .= "Jika Anda sudah membayar, abaikan pesan ini.";

        WhatsAppService::sendMessage($booking->phone ?? $booking->customer_whatsapp, $waMessage);
    }
}
