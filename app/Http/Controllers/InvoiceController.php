<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function bookingPdf(Booking $booking)
    {
        // Load all relationships needed for the detailed invoice
        $booking->load(['tour', 'car', 'user']);

        $tour = $booking->tour;

        // Parse trip details from tour's trips JSON
        $tripTypeLabel    = null;
        $tripTypeIncludes = null;
        $tripTypeName     = null;

        if ($tour && $booking->trip_type && $tour->trips) {
            $tripsData = is_string($tour->trips)
                ? json_decode($tour->trips, true)
                : (array) $tour->trips;

            $tripKey = $booking->trip_type;
            if (isset($tripsData[$tripKey])) {
                $tripTypeLabel    = strtoupper($tripKey);
                $tripTypeName     = $tripsData[$tripKey]['name']     ?? null;
                $tripTypeIncludes = $tripsData[$tripKey]['includes'] ?? null;
            } else {
                $tripTypeLabel = strtoupper($booking->trip_type);
            }
        }

        $pdf = Pdf::loadView('invoice', [
            'booking'          => $booking,
            'tour'             => $tour,
            'tripTypeLabel'    => $tripTypeLabel,
            'tripTypeName'     => $tripTypeName,
            'tripTypeIncludes' => $tripTypeIncludes,
        ])->setPaper('a4', 'portrait');

        $filename = 'Invoice-' . ($booking->external_id ?? 'NST-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT)) . '.pdf';

        return $pdf->download($filename);
    }

    public function itineraryPdf(Tour $tour)
    {
        $pdf = Pdf::loadView('invoice', [
            'tour'             => $tour,
            'booking'          => null,
            'tripTypeLabel'    => null,
            'tripTypeName'     => null,
            'tripTypeIncludes' => null,
        ])->setPaper('a4', 'portrait');

        $filename = 'Itinerary-' . $tour->slug . '.pdf';

        return $pdf->download($filename);
    }
}
