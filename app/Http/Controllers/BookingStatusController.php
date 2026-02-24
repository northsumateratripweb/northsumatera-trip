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
        $orderId = $request->order_id ?? $request->query('order_id');
        $phone = $request->phone ?? $request->query('phone');

        if (!$orderId || !$phone) {
            return view('booking-status');
        }

        $booking = Booking::with(['tour', 'car'])
            ->where('external_id', $orderId)
            ->where(function($query) use ($phone) {
                $query->where('phone', $phone)
                      ->orWhere('customer_whatsapp', $phone);
            })
            ->first();

        if (! $booking) {
            return redirect()->route('booking.status')->with('error', 'Pesanan tidak ditemukan. Pastikan Order ID dan No. WhatsApp sudah benar.');
        }

        return view('booking-status', compact('booking'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // Max 2MB
        ]);

        $booking = Booking::findOrFail($id);
        
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $booking->update([
                'payment_proof' => $path
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasi pesanan Anda.');
    }
}
