<?php

namespace App\Http\Controllers;

use App\Models\TripData;
use Illuminate\Http\Request;

class TripDataPdfController extends Controller
{
    public function generatePdf(TripData $tripData)
    {
        return view('trip-data-pdf', compact('tripData'));
    }
}
