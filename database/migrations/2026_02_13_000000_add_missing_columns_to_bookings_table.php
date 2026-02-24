<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'email')) {
                $table->string('email')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('bookings', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('bookings', 'external_id')) {
                $table->string('external_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('bookings', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('external_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'payment_status', 'external_id', 'snap_token']);
        });
    }
};
