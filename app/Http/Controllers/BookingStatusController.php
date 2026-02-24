<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingStatusController extends Controller
{
    public function index()
    {
        return view('booking-status');
    }

    public function check(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'phone' => 'required',
        ]);

        $booking = Booking::with('tour')
            ->where('external_id', $request->order_id)
            ->where('phone', $request->phone)
            ->first();

        if (! $booking) {
            return back()->with('error', 'Pesanan tidak ditemukan. Pastikan Order ID dan No. WhatsApp sudah benar.');
        }

        return view('booking-status', compact('booking'));
    }
}
