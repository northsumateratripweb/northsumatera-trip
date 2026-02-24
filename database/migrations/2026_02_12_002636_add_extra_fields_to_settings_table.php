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
            $table->text('address')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->string('youtube_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('favicon')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('midtrans_client_key')->nullable();
            $table->string('midtrans_server_key')->nullable();
            $table->boolean('midtrans_is_production')->default(false);
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'address', 'business_hours', 'timezone', 'youtube_url', 'twitter_url',
                'favicon', 'google_analytics_id', 'midtrans_client_key', 'midtrans_server_key',
                'midtrans_is_production', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
            ]);
        });
    }
};
