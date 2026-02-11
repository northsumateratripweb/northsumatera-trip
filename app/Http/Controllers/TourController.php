<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Post;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        // Mengambil semua data yang dibutuhkan Landing Page
        $tours = Tour::all();
        $posts = Post::where('is_published', true)->latest()->take(3)->get();
        $cars = Car::where('is_available', true)->get(); // Mengambil data mobil

        // Mengirimkan semuanya ke view welcome
        return view('welcome', compact('tours', 'posts', 'cars'));
    }

    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        return view('tour-booking', compact('tour'));
    }

    public function checkout(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'TRIP-' . uniqid();
        $quantity = $request->qty ?? 1;
        $basePrice = $tour->price;
        
        // Jika ada trip tertentu, gunakan harga dari trip
        if ($request->has('trip_id') && $tour->trips && isset($tour->trips[$request->trip_id])) {
            $basePrice = $tour->trips[$request->trip_id]['price'] ?? $tour->price;
        }
        
        $grossAmount = $basePrice * $quantity;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name ?? 'Customer',
                'email' => $request->email ?? 'customer@test.com',
                'phone' => $request->phone ?? '08000000000',
            ],
            'item_details' => [
                [
                    'id' => $tour->id,
                    'price' => $basePrice,
                    'quantity' => $quantity,
                    'name' => $tour->title . ($request->trip_id ? ' - Trip ' . strtoupper($request->trip_id) : ''),
                ],
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create payment token'], 500);
        }
        
        // Simpan ke database bookings dengan status pending
        $booking = Booking::create([
            'tour_id' => $tour->id,
            'customer_name' => $request->customer_name ?? 'Customer',
            'email' => $request->email ?? 'customer@test.com',
            'phone' => $request->phone ?? '08000000000',
            'travel_date' => $request->travel_date ?? now()->format('Y-m-d'),
            'qty' => $quantity,
            'total_price' => $grossAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'external_id' => $orderId,
            'snap_token' => $snapToken,
        ]);

        // Jika request via AJAX, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ]);
        }

        return view('checkout', compact('snapToken', 'tour', 'booking'));
    }
}
