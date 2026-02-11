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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Toyota Avanza
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->integer('capacity'); // Jumlah penumpang
            $table->string('transmission')->nullable(); // Transmisi: Manual/Automatic
            $table->bigInteger('price_per_day');
            $table->boolean('is_available')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
