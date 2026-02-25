<?php

namespace Tests\Feature\Components;

use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Test for Tour Packages Section
 * Feature: travel-website-redesign
 * 
 * **Validates: Requirements 3.1, 3.2, 3.3, 3.4**
 */
class TourPackagesSectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 5: Tour packages always display complete information
     * 
     * For any tour package card, the following elements MUST be present:
     * - Large photo
     * - Clear pricing
     * - Trip duration
     * - Action button
     * 
     * **Validates: Requirements 3.1, 3.2, 3.3, 3.4**
     * 
     * @test
     */
    public function tour_packages_always_display_complete_information()
    {
        // Generate multiple random tour packages to test the property
        $iterations = 20;
        
        for ($i = 0; $i < $iterations; $i++) {
            // Create a tour with random data
            $tour = Tour::factory()->create([
                'title' => fake()->sentence(3),
                'description' => fake()->paragraph(),
                'price' => fake()->numberBetween(500000, 10000000),
                'duration_days' => fake()->numberBetween(1, 14),
                'location' => fake()->city(),
                'thumbnail' => 'https://picsum.photos/800/600?random=' . $i,
            ]);

            // Render the package card component
            $view = $this->blade(
                '<x-tour-packages.package-card :package="$package" />',
                ['package' => $tour]
            );

            // Assert: Large photo is present
            $view->assertSee('img', false);
            $view->assertSeeInOrder([
                $tour->image_url ?? asset('images/default-tour.jpg'),
                $tour->title
            ], false);

            // Assert: Clear pricing is displayed
            $view->assertSee('Rp ' . number_format($tour->price, 0, ',', '.'), false);
            
            // Assert: Trip duration is displayed
            $view->assertSee($tour->duration_days, false);
            
            // Assert: Action button is present
            $view->assertSee('Book Now', false);
            $view->assertSee(route('checkout', $tour->id), false);
        }

        $this->assertTrue(true, 'All tour packages displayed complete information across ' . $iterations . ' iterations');
    }

    /**
     * Property: Tour packages grid maintains responsive layout
     * 
     * For any screen size, the tour packages grid MUST adapt appropriately:
     * - Desktop: 3 columns
     * - Tablet: 2 columns
     * - Mobile: 1 column
     * 
     * **Validates: Requirements 3.5, 8.1, 8.2, 8.3**
     * 
     * @test
     */
    public function tour_packages_grid_maintains_responsive_layout()
    {
        // Create multiple tours
        $tours = Tour::factory()->count(6)->create();

        // Render the tour packages section
        $view = $this->blade(
            '<x-tour-packages.tour-packages-section :packages="$packages" />',
            ['packages' => $tours]
        );

        // Assert: Grid classes are present for responsive behavior
        $view->assertSee('grid', false);
        $view->assertSee('grid-cols-1', false); // Mobile: 1 column
        $view->assertSee('md:grid-cols-2', false); // Tablet: 2 columns
        $view->assertSee('lg:grid-cols-3', false); // Desktop: 3 columns

        // Assert: All tours are rendered
        foreach ($tours as $tour) {
            $view->assertSee($tour->title, false);
        }
    }

    /**
     * Property: Empty state displays appropriate message
     * 
     * For any tour packages section with no packages,
     * an appropriate empty state message MUST be displayed
     * 
     * @test
     */
    public function empty_tour_packages_display_appropriate_message()
    {
        // Render with empty packages array
        $view = $this->blade(
            '<x-tour-packages.tour-packages-section :packages="$packages" />',
            ['packages' => []]
        );

        // Assert: Empty state message is displayed
        $view->assertSee('No tour packages available', false);
    }

    /**
     * Property: Package cards have proper hover effects
     * 
     * For any package card, hover effects MUST be applied
     * to enhance user interaction
     * 
     * @test
     */
    public function package_cards_have_proper_hover_effects()
    {
        $tour = Tour::factory()->create();

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        // Assert: Hover classes are present
        $view->assertSee('hover:shadow-2xl', false);
        $view->assertSee('hover:-translate-y-2', false);
        $view->assertSee('group-hover:scale-110', false);
    }
}
