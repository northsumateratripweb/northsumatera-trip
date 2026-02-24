<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trip_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_data_id')->constrained('trip_data')->onDelete('cascade');
            $table->string('item');
            $table->boolean('is_done')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_checklists');
    }
};

