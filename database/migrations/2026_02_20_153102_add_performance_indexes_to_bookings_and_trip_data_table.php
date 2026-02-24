<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Indexes for Bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('external_id');
            $table->index('payment_status');
            $table->index('status');
            $table->index('travel_date');
            $table->index('user_id');
        });

        // Indexes for Trip Data table
        Schema::table('trip_data', function (Blueprint $table) {
            $table->index('tanggal');
            $table->index('status');
            $table->index('booking_id');
            $table->index('nama_pelanggan');
            $table->index('nomor_hp');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['external_id']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['status']);
            $table->dropIndex(['travel_date']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('trip_data', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['status']);
            $table->dropIndex(['booking_id']);
            $table->dropIndex(['nama_pelanggan']);
            $table->dropIndex(['nomor_hp']);
        });
    }
};
