<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('id_value')->nullable(); // Indonesia
            $table->text('en_value')->nullable(); // Inggris
            $table->text('ms_value')->nullable(); // Malaysia
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
