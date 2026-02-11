<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create sample tours with trip variants
        Tour::create([
            'title' => 'Danau Toba Adventure',
            'slug' => 'danau-toba-adventure',
            'location' => 'Medan, North Sumatra',
            'price' => 450000,
            'duration_days' => 3,
            'description' => '<p>Experience the majesty of Lake Toba, the world\'s largest volcanic lake. Enjoy stunning views, water activities, and authentic North Sumatran culture.</p>',
            'itinerary' => '<h3>Day 1: Arrival & City Tour</h3><p>Arrive in Medan, visit Maimun Palace and Mesjid Raya.</p><h3>Day 2: Lake Toba</h3><p>Travel to Lake Toba, explore Samosir Island.</p><h3>Day 3: Return</h3><p>Morning activities and return to Medan.</p>',
            'thumbnail' => 'https://via.placeholder.com/400x300?text=Danau+Toba',
            'trips' => (object)[
                'a' => (object)['name' => 'Basic', 'price' => 380000, 'includes' => 'Hotel + Meals'],
                'b' => (object)['name' => 'Comfort', 'price' => 450000, 'includes' => 'Hotel + Meals + Guide'],
                'c' => (object)['name' => 'Premium', 'price' => 580000, 'includes' => 'Hotel + Meals + Guide + Activities'],
                'd' => (object)['name' => 'Luxury', 'price' => 750000, 'includes' => '5-star Resort + All Inclusive'],
                'e' => (object)['name' => 'VIP', 'price' => 950000, 'includes' => 'Private + Luxury + Driver'],
            ]
        ]);

        Tour::create([
            'title' => 'Berastagi Mountain Trek',
            'slug' => 'berastagi-mountain-trek',
            'location' => 'Berastagi, North Sumatra',
            'price' => 380000,
            'duration_days' => 2,
            'description' => '<p>Climb the majestic Mount Sinabung and Mount Sibayak. Experience volcanic landscapes and panoramic mountain views.</p>',
            'itinerary' => '<h3>Day 1: Arrival & Preparation</h3><p>Arrive in Berastagi, prepare for mountain trek.</p><h3>Day 2: Mountain Climb</h3><p>Early morning climb Mount Sibayak with guide, return by afternoon.</p>',
            'thumbnail' => 'https://via.placeholder.com/400x300?text=Berastagi',
            'trips' => [
                'a' => ['name' => 'Budget', 'price' => 250000, 'includes' => 'Guide + Accommodation'],
                'b' => ['name' => 'Standard', 'price' => 380000, 'includes' => 'Guide + Hotel + Meals'],
                'c' => ['name' => 'Premium', 'price' => 520000, 'includes' => 'Guide + Hotel + Meals + Equipment'],
                'd' => ['name' => 'Deluxe', 'price' => 680000, 'includes' => '5-star + All + Porter'],
            ]
        ]);

        Tour::create([
            'title' => 'Nias Island Beach Paradise',
            'slug' => 'nias-island-beach-paradise',
            'location' => 'Nias Island, North Sumatra',
            'price' => 520000,
            'duration_days' => 4,
            'description' => '<p>Discover pristine beaches, world-class surfing spots, and unique Niasian culture on remote Nias Island.</p>',
            'itinerary' => '<h3>Day 1: Fly to Nias</h3><p>Flight to Nias, settle in resort.</p><h3>Day 2-3: Beach & Water Activities</h3><p>Snorkeling, surfing, beach exploration.</p><h3>Day 4: Cultural Tour & Return</h3><p>Visit traditional villages, return flight.</p>',
            'thumbnail' => 'https://via.placeholder.com/400x300?text=Nias+Island',
            'trips' => [
                'a' => ['name' => 'Economy', 'price' => 380000, 'includes' => 'Flight + Basic Hotel'],
                'b' => ['name' => 'Standard', 'price' => 520000, 'includes' => 'Flight + 3-star Resort + Meals'],
                'c' => ['name' => 'Premium', 'price' => 750000, 'includes' => 'Flight + Beach Resort + All Activities'],
                'd' => ['name' => 'Luxury Resort', 'price' => 1050000, 'includes' => 'Flight + 5-star + Spa + All Inclusive'],
                'e' => ['name' => 'Ultimate VIP', 'price' => 1450000, 'includes' => 'Private Villa + Chef + Yacht'],
            ]
        ]);
    }
}
