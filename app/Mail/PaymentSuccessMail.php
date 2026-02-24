<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public ?Tour $tour;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->tour = Tour::find($booking->tour_id);
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran Berhasil #'.($this->booking->external_id ?? $this->booking->id))
            ->view('emails.payment-success')
            ->with([
                'booking' => $this->booking,
                'tour' => $this->tour,
            ]);
    }
}
