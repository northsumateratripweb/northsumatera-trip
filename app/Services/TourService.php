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

        // Midtrans Config
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'TRIP-' . uniqid();
        $quantity = $data['qty'] ?? 1;
        $basePrice = $tour->price;

        if (isset($data['trip_id']) && $tour->trips && isset($tour->trips[$data['trip_id']])) {
            $basePrice = $tour->trips[$data['trip_id']]['price'] ?? $tour->price;
        }

        $grossAmount = $basePrice * $quantity;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $data['customer_name'] ?? 'Customer',
                'email' => $data['email'] ?? 'customer@test.com',
                'phone' => $data['phone'] ?? '08000000000',
            ],
            'item_details' => [
                [
                    'id' => $tour->id,
                    'price' => $basePrice,
                    'quantity' => $quantity,
                    'name' => $tour->title . (isset($data['trip_id']) ? ' - Trip ' . strtoupper($data['trip_id']) : ''),
                ],
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            throw new \App\Exceptions\BookingException('Gagal membuat token pembayaran: ' . $e->getMessage());
        }

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
            'snap_token' => $snapToken,
        ]);

        return [
            'booking' => $booking,
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
            'tour' => $tour,
        ];
    }
}
