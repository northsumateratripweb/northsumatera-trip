<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CsvImportSeeder extends Seeder
{
    public function run()
    {
        $file = base_path('TRIP - JANUARI.csv');
        if (!file_exists($file)) {
            $this->command->error("File not found: $file");
            return;
        }

        // Optional: Clear existing bookings to start fresh
        // Booking::truncate();

        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);

        if (!$headers) return;

        $count = 0;
        while (($data = fgetcsv($handle)) !== false) {
            // Ensure data matches headers count
            if (count($data) !== count($headers)) continue;

            $row = array_combine($headers, $data);
            
            // Skip empty or placeholder rows (template rows)
            // A row is considered valid if it has a customer name or a specific service type that isn't just a placeholder
            if (empty($row['Nama Pelanggan']) && empty($row['Nomor HP']) && empty($row['Harga'])) {
                // If it's a template row with just "Packet Trip" and "Pilihan Lain", skip it
                if (isset($row['Layanan']) && $row['Layanan'] === 'Paket Trip' && str_contains($row['Hotel 1'] ?? '', 'Pilihan Lain')) {
                    continue;
                }
                
                // If absolutely everything is empty after trimming, skip
                if (empty(array_filter($data, fn($v) => !empty(trim($v)) && $v !== 'FALSE'))) {
                    continue;
                }
            }

            try {
                Booking::create([
                    'travel_date'       => $this->parseDate($row['Tanggal']),
                    'customer_name'     => $row['Nama Pelanggan'] ?: 'Pelanggan Januari',
                    'status'            => $row['Status'] ?: 'Sudah Booking',
                    'customer_whatsapp' => $row['Nomor HP'],
                    'nama_driver'       => $row['Nama Driver'],
                    'booking_type'      => (isset($row['Layanan']) && str_contains(strtolower($row['Layanan']), 'rent')) ? 'car' : 'tour',
                    'plat_mobil'        => $row['Plat Mobil'],
                    'jenis_mobil'       => $row['Jenis Mobil'],
                    'use_drone'         => filter_var($row['Drone'] ?? 'FALSE', FILTER_VALIDATE_BOOLEAN),
                    'duration_days'     => (int)$row['Jumlah Hari'] ?: 1,
                    'qty'               => (int)$row['Penumpang'] ?: 1,
                    'hotel_1'           => $row['Hotel 1'],
                    'hotel_2'           => $row['Hotel 2'],
                    'hotel_3'           => $row['Hotel 3'],
                    'hotel_4'           => $row['Hotel 4'],
                    'total_price'       => $this->parseMoney($row['Harga']),
                    'deposit'           => $this->parseMoney($row['Deposit']),
                    'pelunasan'         => $this->parseMoney($row['Pelunasan']),
                    'tiba'              => $this->parseDate($row['Tiba']),
                    'flight_balik'      => $row['Flight Balik'],
                    'notes'             => 'Imported from TRIP - JANUARI.csv'
                ]);
                $count++;
            } catch (\Exception $e) {
                \Log::warning("Failed to import CSV row: " . $e->getMessage());
            }
        }
        fclose($handle);

        $this->command->info("Successfully imported $count rows from January Trip CSV.");
    }

    private function parseDate($date)
    {
        if (empty($date) || $date === '-' || $date === 'TBC') return null;
        try {
            return Carbon::createFromFormat('d/m/Y', trim($date));
        } catch (\Exception $e) {
            try {
                return Carbon::parse($date);
            } catch (\Exception $e2) {
                return null;
            }
        }
    }

    private function parseMoney($money)
    {
        if (empty($money)) return 0;
        // Strip non-numeric except decimal if any
        $clean = preg_replace('/[^0-9]/', '', $money);
        return (float)$clean;
    }
}
