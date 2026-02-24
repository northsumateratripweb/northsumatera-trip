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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('bank_name_1')->nullable();
            $table->string('bank_account_1')->nullable();
            $table->string('bank_holder_1')->nullable();
            $table->string('bank_name_2')->nullable();
            $table->string('bank_account_2')->nullable();
            $table->string('bank_holder_2')->nullable();
            $table->string('qris_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
