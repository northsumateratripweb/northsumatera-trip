<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'brand')) {
                $table->string('brand')->nullable()->after('name');
            }
            if (!Schema::hasColumn('cars', 'plat_nomor')) {
                $table->string('plat_nomor')->nullable()->after('brand');
            }
            if (!Schema::hasColumn('cars', 'jenis_mobil')) {
                $table->string('jenis_mobil')->nullable()->after('plat_nomor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['brand', 'plat_nomor', 'jenis_mobil']);
        });
    }
};
