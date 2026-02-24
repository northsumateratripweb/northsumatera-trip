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
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreignId('tour_id')->nullable()->change();
            $table->foreignId('car_id')->nullable()->after('tour_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreignId('tour_id')->nullable(false)->change();
            $table->dropForeign(['car_id']);
            $table->dropColumn('car_id');
        });
    }
};
