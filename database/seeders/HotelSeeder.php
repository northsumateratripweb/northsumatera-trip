<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            // Danau Toba
            ['name' => 'Bobocabin Patra',  'location' => 'Danau Toba',  'category' => 'Resort'],
            ['name' => 'Samosir Villa',     'location' => 'Danau Toba',  'category' => 'Mid'],
            ['name' => 'Samosir Cottage',   'location' => 'Danau Toba',  'category' => 'Budget'],
            ['name' => 'Toba Village Inn',  'location' => 'Danau Toba',  'category' => 'Mid'],
            ['name' => 'Saulina Resort',    'location' => 'Danau Toba',  'category' => 'Resort'],

            // Berastagi
            ['name' => 'Kama Hotel',        'location' => 'Berastagi',   'category' => 'Mid'],
            ['name' => 'Kalang Ulu',        'location' => 'Berastagi',   'category' => 'Resort'],
            ['name' => 'Mikie Holiday',     'location' => 'Berastagi',   'category' => 'Mid'],
            ['name' => 'Hotel Sibayak',     'location' => 'Berastagi',   'category' => 'Budget'],
            ['name' => 'Sinabung Resort',   'location' => 'Berastagi',   'category' => 'Resort'],
            ['name' => 'Marianna Resort',   'location' => 'Berastagi',   'category' => 'Mid'],
        ];

        foreach ($hotels as $hotel) {
            Hotel::firstOrCreate(
                ['name' => $hotel['name']],
                array_merge($hotel, ['is_active' => true])
            );
        }

        $this->command->info('✅ Seeded ' . Hotel::count() . ' hotels.');
    }
}
