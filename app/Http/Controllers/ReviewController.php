<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $tourId)
    {
        // Honeypot check
        if ($request->filled('hp_field')) {
            return response()->json(['message' => 'Spam detected'], 403);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $tour = Tour::findOrFail($tourId);

        Review::create([
            'tour_id' => $tour->id,
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_published' => false, // Default to false for moderation
        ]);

        return back()->with('success', 'Terima kasih atas review Anda! Review akan muncul setelah dimoderasi oleh admin.');
    }
}
