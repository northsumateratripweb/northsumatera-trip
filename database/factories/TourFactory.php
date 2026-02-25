<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(3),
            'price' => fake()->numberBetween(500000, 10000000),
            'duration_days' => fake()->numberBetween(1, 14),
            'location' => fake()->city(),
            'thumbnail' => 'https://picsum.photos/800/600?random=' . fake()->numberBetween(1, 1000),
            'itinerary' => fake()->paragraphs(3, true),
            'trip_image' => null,
            'trips' => null,
            'itinerary_url' => null,
        ];
    }
}
