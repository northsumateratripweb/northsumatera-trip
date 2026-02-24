<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class NavigationController extends Controller
{
    public function packages(Request $request)
    {
        $query = \App\Models\Tour::query()->with(['wishlists']);
        
        if ($request->has('q')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('location', 'like', '%' . $request->q . '%');
            });
        }

        $tours = $query->latest()->paginate(9);
        return view('packages', compact('tours'));
    }

    public function rental()
    {
        $cars = \App\Models\Car::where('is_available', true)->latest()->get();
        return view('rental', compact('cars'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);

        // Simpan ke database
        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        // Kirim email notifikasi ke admin
        try {
            Mail::to('admin@northsumatera-trip.com')->send(new ContactMessageMail($contactMessage));
        } catch (\Exception $e) {
            // Ignore email error
        }

        // Kirim WhatsApp notifikasi ke admin
        try {
            WhatsAppService::sendMessage('6281362431111', "Pesan baru dari {$validated['name']} - {$validated['email']}: {$validated['message']}");
        } catch (\Exception $e) {
            // Ignore WhatsApp error
        }

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.');
    }
}