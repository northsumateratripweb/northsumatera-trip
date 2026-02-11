<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('status')->nullable();
            $table->string('phone')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('service')->nullable();
            $table->string('plate')->nullable();
            $table->string('car_type')->nullable();
            $table->boolean('drone')->default(false);
            $table->integer('days')->nullable();
            $table->integer('passengers')->nullable();
            $table->string('hotel_1')->nullable();
            $table->string('hotel_2')->nullable();
            $table->string('hotel_3')->nullable();
            $table->string('hotel_4')->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->decimal('deposit', 14, 2)->nullable();
            $table->decimal('payment', 14, 2)->nullable();
            $table->dateTime('arrived_at')->nullable();
            $table->dateTime('return_flight_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_entries');
    }
};
