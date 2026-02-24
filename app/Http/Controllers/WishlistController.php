<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with(['tour', 'car'])
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', Session::getId());
                }
            })->latest()->get();

        return view('wishlist', compact('wishlists'));
    }

    public function toggle(Request $request, $tourId)
    {
        $tour = \App\Models\Tour::findOrFail($tourId);
        $userId = Auth::id();
        $sessionId = Session::getId();

        $wishlist = Wishlist::where('tour_id', $tour->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Berhasil dihapus dari wishlist';
        } else {
            Wishlist::create([
                'tour_id' => $tour->id,
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
            ]);
            $status = 'added';
            $message = 'Berhasil ditambahkan ke wishlist';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => Wishlist::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->count()
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleCar(Request $request, $carId)
    {
        $car = \App\Models\Car::findOrFail($carId);
        $userId = Auth::id();
        $sessionId = Session::getId();

        $wishlist = Wishlist::where('car_id', $car->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Berhasil dihapus dari wishlist';
        } else {
            Wishlist::create([
                'car_id' => $car->id,
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
            ]);
            $status = 'added';
            $message = 'Berhasil ditambahkan ke wishlist';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => Wishlist::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->count()
            ]);
        }

        return back()->with('success', $message);
    }
}
