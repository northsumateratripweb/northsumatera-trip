<?php

namespace Tests\Unit\Components;

use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourPackagesSectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_tour_packages_section_with_title_and_subtitle()
    {
        $tours = Tour::factory()->count(3)->create();

        $view = $this->blade(
            '<x-tour-packages.tour-packages-section :packages="$packages" title="Featured Tours" subtitle="Explore our best destinations" />',
            ['packages' => $tours]
        );

        $view->assertSee('Featured Tours', false);
        $view->assertSee('Explore our best destinations', false);
    }

    /** @test */
    public function it_renders_package_card_with_all_required_elements()
    {
        $tour = Tour::factory()->create([
            'title' => 'Bali Adventure',
            'description' => 'Experience the beauty of Bali',
            'price' => 5000000,
            'duration_days' => 5,
            'location' => 'Bali',
        ]);

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        $view->assertSee('Bali Adventure', false);
        $view->assertSee('Experience the beauty of Bali', false);
        $view->assertSee('Rp 5.000.000', false);
        $view->assertSee('5', false);
        $view->assertSee('Days', false);
        $view->assertSee('Bali', false);
        $view->assertSee('Book Now', false);
    }

    /** @test */
    public function it_displays_default_image_when_thumbnail_is_missing()
    {
        $tour = Tour::factory()->create([
            'thumbnail' => 'https://picsum.photos/800/600',
        ]);

        // Manually set the thumbnail to null to test the fallback
        $tour->thumbnail = null;

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        $view->assertSee('images/default-tour.jpg', false);
    }

    /** @test */
    public function it_truncates_long_descriptions()
    {
        $longDescription = str_repeat('This is a very long description. ', 20);
        
        $tour = Tour::factory()->create([
            'description' => $longDescription,
        ]);

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        // The description should be truncated (line-clamp-3 CSS class)
        $view->assertSee('line-clamp-3', false);
    }

    /** @test */
    public function it_generates_correct_booking_link()
    {
        $tour = Tour::factory()->create([
            'slug' => 'bali-adventure',
        ]);

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        $view->assertSee(route('checkout', $tour->id), false);
    }

    /** @test */
    public function it_displays_empty_state_when_no_packages()
    {
        $view = $this->blade(
            '<x-tour-packages.tour-packages-section :packages="$packages" />',
            ['packages' => []]
        );

        $view->assertSee('No tour packages available', false);
    }

    /** @test */
    public function it_applies_responsive_grid_classes()
    {
        $tours = Tour::factory()->count(3)->create();

        $view = $this->blade(
            '<x-tour-packages.tour-packages-section :packages="$packages" />',
            ['packages' => $tours]
        );

        $view->assertSee('grid-cols-1', false);
        $view->assertSee('md:grid-cols-2', false);
        $view->assertSee('lg:grid-cols-3', false);
    }

    /** @test */
    public function it_formats_price_correctly()
    {
        $tour = Tour::factory()->create([
            'price' => 1234567,
        ]);

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        $view->assertSee('Rp 1.234.567', false);
    }

    /** @test */
    public function it_includes_accessibility_attributes()
    {
        $tour = Tour::factory()->create([
            'title' => 'Bali Adventure',
        ]);

        $view = $this->blade(
            '<x-tour-packages.package-card :package="$package" />',
            ['package' => $tour]
        );

        $view->assertSee('aria-label', false);
        $view->assertSee('loading="lazy"', false);
    }
}
