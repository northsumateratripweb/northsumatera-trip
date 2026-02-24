<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp menggunakan Fonnte API
     * 
     * @param string $target Nomor tujuan (62812...)
     * @param string $message Isi pesan
     * @return bool
     */
    public static function sendMessage($target, $message)
    {
        $token = config('services.fonnte.token');
        
        if (!$token) {
            Log::warning('WhatsApp Service: FONNTE_TOKEN tidak ditemukan di .env');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Default Indonesia
            ]);

            $result = $response->json();
            
            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                return true;
            }

            Log::error('WhatsApp Service Error: ' . ($result['reason'] ?? 'Unknown error'));
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}
