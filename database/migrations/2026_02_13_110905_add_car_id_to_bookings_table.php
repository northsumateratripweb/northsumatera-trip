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
            $table->foreignId('car_id')->nullable()->after('tour_id')->constrained()->onDelete('set null');
            $table->string('booking_type')->default('tour')->after('id');
            $table->integer('duration_days')->nullable()->after('qty');
            $table->foreignId('tour_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn(['car_id', 'booking_type', 'duration_days']);
            $table->foreignId('tour_id')->nullable(false)->change();
        });
    }
};
