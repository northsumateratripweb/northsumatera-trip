<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $bookings = Booking::with(['tour', 'car'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total' => $bookings->count(),
            'completed' => $bookings->where('payment_status', 'paid')->count(),
            'pending' => $bookings->where('payment_status', 'pending')->count(),
        ];

        return view('dashboard', compact('bookings', 'stats'));
    }
}
