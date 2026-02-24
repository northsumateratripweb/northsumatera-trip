<?php

use App\Http\Controllers\BookingStatusController;
use App\Http\Controllers\CarBookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TripDataPdfController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [RobotsController::class, 'index']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [TourController::class, 'index'])->name('home');
Route::get('/packages', [NavigationController::class, 'packages'])->name('packages');
Route::get('/rental', [NavigationController::class, 'rental'])->name('rental');
Route::get('/contact', [NavigationController::class, 'contact'])->name('contact');
Route::post('/contact', [NavigationController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:3,1');
Route::get('/tour/{slug}', [TourController::class, 'show'])->name('tour.show');
Route::match(['get', 'post'], '/checkout/{id}', [TourController::class, 'checkout'])->name('checkout')->middleware('throttle:5,1');
Route::match(['get', 'post'], '/car-checkout/{id}', [CarBookingController::class, 'checkout'])->name('car.checkout')->middleware('throttle:5,1');

// Booking Status
Route::get('/booking-status', [BookingStatusController::class, 'index'])->name('booking.status');
Route::post('/booking-status', [BookingStatusController::class, 'check'])->name('booking.check')->middleware('throttle:5,1');

Route::get('/blog/{slug}', function ($slug) {
    $post = \App\Models\Post::where('slug', $slug)->firstOrFail();

    return view('post-detail', compact('post'));
})->name('post.show');
// Route untuk Detail Mobil
Route::get('/rental/{id}', function ($id) {
    $car = \App\Models\Car::findOrFail($id);

    return view('car-detail', compact('car'));
})->name('car.show');

// Route untuk Daftar Blog Lengkap
Route::get('/blog', function () {
    $posts = \App\Models\Post::where('is_published', true)->latest()->paginate(9);

    return view('blog-index', compact('posts'));
})->name('blog.index');
Route::get('/page/{slug}', [StaticPageController::class, 'show'])->name('page.show');
Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

// Invoice PDF download
Route::get('/invoice/{booking}/pdf', [InvoiceController::class, 'bookingPdf'])
    ->name('invoice.pdf');

// Itinerary PDF download
Route::get('/itinerary/{tour}/pdf', [InvoiceController::class, 'itineraryPdf'])
    ->name('itinerary.pdf');

// Trip Data PDF
Route::get('/trip-data/{tripData}/pdf', [TripDataPdfController::class, 'generatePdf'])
    ->name('trip-data.pdf');


// Gallery frontend
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{tourId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle')->middleware('throttle:10,1');
Route::post('/wishlist/toggle-car/{carId}', [WishlistController::class, 'toggleCar'])->name('wishlist.toggle-car')->middleware('throttle:10,1');

// Reviews
Route::post('/tour/{tourId}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store')->middleware('throttle:3,1');

// Legal Pages
Route::get('/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');
