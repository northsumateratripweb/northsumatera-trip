<?php

namespace Database\Seeders;

use App\Models\SocialFeed;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class SocialFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourImages = Tour::pluck('thumbnail')->take(4)->toArray();
        
        $feeds = [
            [
                'caption' => 'Menikmati sunset di Danau Toba #NorthSumateraTrip',
                'instagram_url' => 'https://instagram.com/p/DB123456789',
            ],
            [
                'caption' => 'Petualangan seru di Bukit Lawang! #SumateraTravel',
                'instagram_url' => 'https://instagram.com/p/DB987654321',
            ],
            [
                'caption' => 'Air Terjun Sipiso-piso yang memukau. #VisitSumut',
                'instagram_url' => 'https://instagram.com/p/DB456789123',
            ],
            [
                'caption' => 'Kuliner malam di Medan memang juara! #MedanFood',
                'instagram_url' => 'https://instagram.com/p/DB321654987',
            ],
        ];

        foreach ($feeds as $index => $feed) {
            SocialFeed::create([
                'image' => $tourImages[$index] ?? 'tours/default.jpg',
                'caption' => $feed['caption'],
                'instagram_url' => $feed['instagram_url'],
                'is_active' => true,
                'order' => $index,
            ]);
        }
    }
}
