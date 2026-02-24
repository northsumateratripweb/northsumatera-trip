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
        Schema::create('trip_data', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pelanggan');
            $table->string('status')->default('Sudah Booking');
            $table->string('nomor_hp');
            $table->string('nama_driver')->nullable();
            $table->string('layanan'); // Tour/Car Rental/etc
            $table->string('plat_mobil')->nullable();
            $table->string('jenis_mobil')->nullable();
            $table->boolean('drone')->default(false);
            $table->integer('jumlah_hari')->default(1);
            $table->integer('penumpang')->default(1);
            $table->string('hotel_1')->nullable();
            $table->string('hotel_2')->nullable();
            $table->string('hotel_3')->nullable();
            $table->string('hotel_4')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('deposit', 15, 2)->default(0);
            $table->decimal('pelunasan', 15, 2)->default(0);
            $table->date('tiba')->nullable();
            $table->string('flight_balik')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_data');
    }
};
