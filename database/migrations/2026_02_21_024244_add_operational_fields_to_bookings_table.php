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
            $table->string('nama_driver')->nullable()->after('payment_link');
            $table->string('plat_mobil')->nullable()->after('nama_driver');
            $table->string('jenis_mobil')->nullable()->after('plat_mobil');
            $table->string('hotel_1')->nullable()->after('jenis_mobil');
            $table->string('hotel_2')->nullable()->after('hotel_1');
            $table->string('hotel_3')->nullable()->after('hotel_2');
            $table->string('hotel_4')->nullable()->after('hotel_3');
            $table->decimal('deposit', 15, 2)->default(0)->after('hotel_4');
            $table->decimal('pelunasan', 15, 2)->default(0)->after('deposit');
            $table->date('tiba')->nullable()->after('pelunasan');
            $table->string('flight_balik')->nullable()->after('tiba');
            $table->text('notes')->nullable()->after('flight_balik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'nama_driver',
                'plat_mobil',
                'jenis_mobil',
                'hotel_1',
                'hotel_2',
                'hotel_3',
                'hotel_4',
                'deposit',
                'pelunasan',
                'tiba',
                'flight_balik',
                'notes',
            ]);
        });
    }
};
