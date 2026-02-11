<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TripDataPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourController::class, 'index'])->name('home');
Route::get('/tour/{slug}', [TourController::class, 'show'])->name('tour.show');
Route::match(['get', 'post'], '/checkout/{id}', [TourController::class, 'checkout'])->name('checkout');
Route::get('/blog/{slug}', function($slug) {
    $post = \App\Models\Post::where('slug', $slug)->firstOrFail();
    return view('post-detail', compact('post'));
})->name('post.show');
// Route untuk Detail Mobil
Route::get('/rental/{id}', function($id) {
    $car = \App\Models\Car::findOrFail($id);
    return view('car-detail', compact('car'));
})->name('car.show');

// Route untuk Daftar Blog Lengkap
Route::get('/blog', function() {
    $posts = \App\Models\Post::where('is_published', true)->latest()->paginate(9);
    return view('blog-index', compact('posts'));
})->name('blog.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Language switcher (en, id, ms)
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id', 'ms'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Invoice view (printable)
Route::get('/invoice/{booking}', function (\App\Models\Booking $booking) {
    return view('invoice', compact('booking'));
})->name('invoice.show');

// Trip Data PDF
Route::get('/trip-data/{tripData}/pdf', [TripDataPdfController::class, 'generatePdf'])
    ->name('trip-data.pdf');
