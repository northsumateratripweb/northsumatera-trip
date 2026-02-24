<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPostTripFollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trip:send-followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp follow-up messages to customers after their trip ends.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting post-trip follow-up process...');

        // Query bookings that ended yesterday
        $yesterday = Carbon::yesterday()->toDateString();
        
        $bookings = Booking::where('travel_date', $yesterday)
            ->where('payment_status', 'paid')
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings found for yesterday.');
            return 0;
        }

        foreach ($bookings as $booking) {
            $this->sendFollowUp($booking);
        }

        $this->info('Follow-up process completed.');
        return 0;
    }

    protected function sendFollowUp(Booking $booking)
    {
        $itemName = $booking->booking_type === 'car' 
            ? ($booking->car->name ?? 'Sewa Mobil') 
            : ($booking->tour->title ?? 'Paket Wisata');

        $message = "*TERIMA KASIH TELAH BERWISATA DENGAN KAMI!* 🌟\n\n";
        $message .= "Halo " . $booking->customer_name . ",\n";
        $message .= "Terima kasih telah mempercayakan perjalanan/penyewaan *" . $itemName . "* kepada NorthSumateraTrip.\n\n";
        $message .= "Kami berharap Anda memiliki pengalaman yang luar biasa selama di Sumatera Utara. Kami akan sangat menghargai jika Anda berkenan memberikan ulasan tentang layanan kami untuk membantu kami menjadi lebih baik.\n\n";
        
        if ($booking->booking_type !== 'car' && $booking->tour) {
            $message .= "*Berikan Ulasan di Sini:* \n";
            $message .= route('tour.show', $booking->tour->slug) . "#reviews \n\n";
        }

        $message .= "Sampai jumpa di perjalanan berikutnya! 👋";

        $target = $booking->phone ?? $booking->customer_whatsapp;
        
        if ($target) {
            $this->info("Sending follow-up to {$booking->customer_name} ({$target})...");
            $success = WhatsAppService::sendMessage($target, $message);
            
            if ($success) {
                $this->info("Follow-up sent successfully.");
            } else {
                $this->error("Failed to send follow-up to {$booking->customer_name}.");
            }
        }
    }
}
