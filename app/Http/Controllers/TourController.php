<?php

namespace App\Http\Controllers;

use App\Services\TourService;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

class TourController extends Controller
{
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function index(Request $request)
    {
        $data = $this->tourService->getLandingPageData($request->all());
        return view('welcome', $data);
    }

    public function show($slug)
    {
        $data = $this->tourService->getTourBySlug($slug);
        return view('tour-booking', $data);
    }

    public function checkout(StoreBookingRequest $request, $id)
    {
        $result = $this->tourService->processCheckout($id, $request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'snap_token' => $result['snap_token'],
                'order_id' => $result['order_id'],
                'gross_amount' => $result['gross_amount'],
                'payment_info' => $result['payment_info'],
            ]);
        }

        return view('checkout', [
            'snapToken' => $result['snap_token'],
            'tour' => $result['tour'],
            'booking' => $result['booking']
        ]);
    }
}