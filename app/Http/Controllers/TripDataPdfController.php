<?php

namespace App\Http\Controllers;

use App\Models\TripData;
use Barryvdh\DomPDF\Facade\Pdf;

class TripDataPdfController extends Controller
{
    public function generatePdf(TripData $tripData)
    {
        $tripData->load('booking.tour', 'booking.car');
        $pdf = Pdf::loadView('trip-data-pdf', compact('tripData'))
            ->setPaper('a4', 'portrait');

        $filename = 'TripData-'.$tripData->id.'.pdf';

        return $pdf->download($filename);
    }
}
