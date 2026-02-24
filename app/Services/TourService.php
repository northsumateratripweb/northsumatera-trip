<?php

namespace App\Services;

use App\Repositories\Contracts\TourRepositoryInterface;
use App\Repositories\Contracts\CarRepositoryInterface;
use App\Models\Post;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class TourService
{
    protected $tourRepository;
    protected $carRepository;

    public function __construct(
        TourRepositoryInterface $tourRepository,
        CarRepositoryInterface $carRepository
    ) {
        $this->tourRepository = $tourRepository;
        $this->carRepository = $carRepository;
    }

    public function getLandingPageData()
    {
        return [
            'tours' => $this->tourRepository->with(['wishlists'])->all(),
            'posts' => Post::where('is_published', true)->latest()->take(3)->get(),
            'cars' => $this->carRepository->getAvailable(),
            'banners' => \App\Models\Banner::where('is_active', true)->orderBy('order')->get(),
            'faqs' => \App\Models\Faq::where('is_active', true)->orderBy('order')->get(),
            'stats' => \App\Models\Stat::where('is_active', true)->orderBy('order')->get(),
            'reviews' => \App\Models\Review::with('tour')->where('is_published', true)->latest()->take(6)->get(),
        ];
    }

    public function getTourBySlug($slug)
    {
        return [
            'tour' => $this->tourRepository->findBySlug($slug),
            'hotels' => \App\Models\Hotel::activeOptions(),
        ];
    }

    public function processCheckout($tourId, array $data)
    {
        $tour = $this->tourRepository->findById($tourId);

        $orderId = 'TRIP-' . strtoupper(uniqid());
        $quantity = $data['qty'] ?? 1;
        $basePrice = $tour->price;

        // Determine price based on selected trip type if applicable
        if (isset($data['trip_id']) && $tour->trips && isset($tour->trips[$data['trip_id']])) {
            $basePrice = $tour->trips[$data['trip_id']]['price'] ?? $tour->price;
        }

        $grossAmount = $basePrice * $quantity;

        // Create Booking
        $booking = Booking::create([
            'tour_id' => $tour->id,
            'trip_type' => $data['trip_id'] ?? null,
            'customer_name' => $data['customer_name'],
            'customer_whatsapp' => $data['customer_whatsapp'] ?? $data['phone'],
            'email' => $data['email'] ?? 'customer@test.com',
            'phone' => $data['phone'],
            'travel_date' => $data['travel_date'],
            'qty' => $quantity,
            'total_price' => $grossAmount,
            'use_drone' => $data['use_drone'] ?? false,
            'hotel_1' => $data['hotel_1'] ?? null,
            'hotel_2' => $data['hotel_2'] ?? null,
            'hotel_3' => $data['hotel_3'] ?? null,
            'hotel_4' => $data['hotel_4'] ?? null,
            'tiba' => $data['tiba'] ?? null,
            'flight_balik' => $data['flight_balik'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
            'payment_status' => 'pending',
            'external_id' => $orderId,
            'snap_token' => null, // No longer using Midtrans
        ]);

        // Create TripData for Admin Dashboard
        \App\Models\TripData::create([
            'booking_id'    => $booking->id,
            'tanggal'       => $booking->travel_date,
            'nama_pelanggan'=> $booking->customer_name,
            'status'        => 'Sudah Booking',
            'nomor_hp'      => $booking->customer_whatsapp ?? $booking->phone,
            'layanan'       => 'Tour Package',
            'jenis_mobil'   => null,
            'drone'         => $booking->use_drone,
            'jumlah_hari'   => $tour->duration_days,
            'penumpang'     => $quantity,
            'hotel_1'       => $booking->hotel_1,
            'hotel_2'       => $booking->hotel_2,
            'hotel_3'       => $booking->hotel_3,
            'hotel_4'       => $booking->hotel_4,
            'harga'         => $booking->total_price,
            'tiba'          => $booking->tiba,
            'flight_balik'  => $booking->flight_balik,
            'notes'         => 'Booking paket: ' . $tour->title . ' | ID: ' . $orderId,
        ]);

        // WhatsApp Notification (Optional, can also be handled in Controller)
        try {
            $waMessage = "✨ *BOOKING PAKET WISATA BERHASIL* ✨\n\n";
            $waMessage .= "Halo *" . $booking->customer_name . "*,\n";
            $waMessage .= "Terima kasih telah memesan paket wisata bersama kami!\n\n";
            $waMessage .= "📋 *DETAIL PESANAN:*\n";
            $waMessage .= "• *ID Pesanan:* " . $booking->external_id . "\n";
            $waMessage .= "• *Paket:* " . $tour->title . "\n";
            $waMessage .= "• *Tgl Perjalanan:* " . \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') . "\n";
            $waMessage .= "• *Peserta:* " . $booking->qty . " Orang\n";
            $waMessage .= "• *Total:* Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n";
            $waMessage .= "Silakan lakukan pembayaran sesuai instruksi di website. Terima kasih! 🙏";

            \App\Services\WhatsAppService::sendMessage($booking->phone, $waMessage);
        } catch (\Exception $e) {
            Log::error('WA Notification Error: ' . $e->getMessage());
        }

        return [
            'booking' => $booking,
            'snap_token' => null,
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
            'tour' => $tour,
        ];
    }
}
