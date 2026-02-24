<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'use_drone')) {
                $table->boolean('use_drone')->default(false)->after('trip_type');
            }
            if (!Schema::hasColumn('bookings', 'booking_type')) {
                $table->string('booking_type')->default('online')->after('use_drone');
            }
            if (!Schema::hasColumn('bookings', 'payment_link')) {
                $table->string('payment_link')->nullable()->after('snap_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['use_drone', 'booking_type', 'payment_link']);
        });
    }
};
