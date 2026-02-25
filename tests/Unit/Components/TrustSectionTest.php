<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

/**
 * Unit tests for TrustSection Blade component
 * 
 * Tests the component in isolation without full HTTP requests.
 * Focuses on component rendering logic, edge cases, and responsive behavior.
 * 
 * Requirements: 2.1, 2.2, 2.3, 2.4
 */
class TrustSectionTest extends TestCase
{
    /**
     * Test that all required elements are rendered
     * 
     * @test
     */
    public function all_required_elements_are_rendered(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [
                ['platform' => 'Google', 'score' => 4.8, 'count' => 150, 'icon' => '⭐'],
            ],
            'travelerCount' => 1000,
            'legalBadges' => [
                ['name' => 'Licensed', 'icon' => 'badge', 'description' => 'Certified'],
            ],
            'testimonials' => [
                ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Great!', 'rating' => 5],
            ],
        ]);

        $rendered = $view->render();
        
        // Check all four required sections
        $this->assertStringContainsString('Trusted by Travelers Worldwide', $rendered);
        $this->assertStringContainsString('Total Travelers Served', $rendered);
        $this->assertStringContainsString('Certifications & Badges', $rendered);
        $this->assertStringContainsString('What Travelers Say', $rendered);
    }

    /**
     * Test that ratings are rendered correctly
     * 
     * @test
     */
    public function ratings_are_rendered_correctly(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [
                ['platform' => 'Google', 'score' => 4.8, 'count' => 150, 'icon' => '⭐'],
            ],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('4.8', $rendered);
        $this->assertStringContainsString('Google', $rendered);
        $this->assertStringContainsString('150', $rendered);
    }

    /**
     * Test that multiple ratings are rendered
     * 
     * @test
     */
    public function multiple_ratings_are_rendered(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [
                ['platform' => 'Google', 'score' => 4.8, 'count' => 150, 'icon' => '⭐'],
                ['platform' => 'TripAdvisor', 'score' => 4.9, 'count' => 200, 'icon' => '⭐'],
            ],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('4.8', $rendered);
        $this->assertStringContainsString('Google', $rendered);
        $this->assertStringContainsString('4.9', $rendered);
        $this->assertStringContainsString('TripAdvisor', $rendered);
    }

    /**
     * Test that traveler count is rendered correctly
     * 
     * @test
     */
    public function traveler_count_is_rendered_correctly(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 5000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Total Travelers Served', $rendered);
        $this->assertStringContainsString('5,000', $rendered);
        $this->assertStringContainsString('And counting...', $rendered);
    }

    /**
     * Test that large traveler count is formatted correctly
     * 
     * @test
     */
    public function large_traveler_count_is_formatted_correctly(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 50000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('50,000', $rendered);
    }

    /**
     * Test that legal badges are rendered correctly
     * 
     * @test
     */
    public function legal_badges_are_rendered_correctly(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [
                ['name' => 'Licensed Tour Operator', 'icon' => 'badge', 'description' => 'Officially certified'],
            ],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Certifications & Badges', $rendered);
        $this->assertStringContainsString('Licensed Tour Operator', $rendered);
        $this->assertStringContainsString('Officially certified', $rendered);
    }

    /**
     * Test that multiple legal badges are rendered
     * 
     * @test
     */
    public function multiple_legal_badges_are_rendered(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [
                ['name' => 'Licensed Tour Operator', 'icon' => 'badge', 'description' => 'Officially certified'],
                ['name' => 'Secure Booking', 'icon' => 'lock', 'description' => 'Safe transactions'],
                ['name' => '24/7 Support', 'icon' => 'headset', 'description' => 'Always available'],
            ],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Licensed Tour Operator', $rendered);
        $this->assertStringContainsString('Secure Booking', $rendered);
        $this->assertStringContainsString('24/7 Support', $rendered);
    }

    /**
     * Test that testimonials are rendered correctly
     * 
     * @test
     */
    public function testimonials_are_rendered_correctly(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [
                ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Amazing experience!', 'rating' => 5],
            ],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('What Travelers Say', $rendered);
        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('Jakarta', $rendered);
        $this->assertStringContainsString('Amazing experience!', $rendered);
    }

    /**
     * Test that multiple testimonials are rendered
     * 
     * @test
     */
    public function multiple_testimonials_are_rendered(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [
                ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Great!', 'rating' => 5],
                ['name' => 'Jane Smith', 'location' => 'Singapore', 'text' => 'Excellent!', 'rating' => 5],
            ],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('Jane Smith', $rendered);
        $this->assertStringContainsString('Jakarta', $rendered);
        $this->assertStringContainsString('Singapore', $rendered);
    }

    /**
     * Test that component handles empty ratings array
     * 
     * @test
     */
    public function component_handles_empty_ratings_array(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        // Should still render the section with default ratings
        $this->assertStringContainsString('Trusted by Travelers Worldwide', $rendered);
        $this->assertStringContainsString('4.8', $rendered);
        $this->assertStringContainsString('Google', $rendered);
    }

    /**
     * Test that component handles empty legal badges array
     * 
     * @test
     */
    public function component_handles_empty_legal_badges_array(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        // Should still render the section with default badges
        $this->assertStringContainsString('Certifications & Badges', $rendered);
        $this->assertStringContainsString('Licensed Tour Operator', $rendered);
        $this->assertStringContainsString('Secure Booking', $rendered);
        $this->assertStringContainsString('24/7 Support', $rendered);
    }

    /**
     * Test that component handles empty testimonials array
     * 
     * @test
     */
    public function component_handles_empty_testimonials_array(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        // Should not render testimonials section when empty
        $this->assertStringNotContainsString('What Travelers Say', $rendered);
    }

    /**
     * Test that component handles zero traveler count
     * 
     * @test
     */
    public function component_handles_zero_traveler_count(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 0,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Total Travelers Served', $rendered);
        $this->assertStringContainsString('0', $rendered);
    }

    /**
     * Test that responsive grid classes are applied
     * 
     * @test
     */
    public function responsive_grid_classes_are_applied(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('grid-cols-1', $rendered);
        $this->assertStringContainsString('md:grid-cols-2', $rendered);
        $this->assertStringContainsString('lg:grid-cols-3', $rendered);
    }

    /**
     * Test that testimonials grid is responsive
     * 
     * @test
     */
    public function testimonials_grid_is_responsive(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [
                ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Great!', 'rating' => 5],
            ],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('grid-cols-1', $rendered);
        $this->assertStringContainsString('sm:grid-cols-2', $rendered);
        $this->assertStringContainsString('lg:grid-cols-3', $rendered);
    }

    /**
     * Test that component uses correct spacing
     * 
     * @test
     */
    public function component_uses_correct_spacing(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('py-16', $rendered);
        $this->assertStringContainsString('sm:py-20', $rendered);
        $this->assertStringContainsString('lg:py-24', $rendered);
        $this->assertStringContainsString('space-y-4', $rendered);
        $this->assertStringContainsString('space-y-6', $rendered);
    }

    /**
     * Test that component uses correct typography from config
     * 
     * @test
     */
    public function component_uses_correct_typography_from_config(): void
    {
        $typography = Config::get('design-tokens.typography');
        
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString($typography['font-family']['sans'], $rendered);
    }

    /**
     * Test that component has proper accessibility attributes
     * 
     * @test
     */
    public function component_has_proper_accessibility_attributes(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [
                ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Great!', 'rating' => 5],
            ],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('role="article"', $rendered);
    }

    /**
     * Test that component handles missing rating data gracefully
     * 
     * @test
     */
    public function component_handles_missing_rating_data_gracefully(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [
                ['platform' => 'Google'], // Missing score and count
            ],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('Trusted by Travelers Worldwide', $rendered);
        $this->assertStringContainsString('Google', $rendered);
    }

    /**
     * Test that component handles missing badge data gracefully
     * 
     * @test
     */
    public function component_handles_missing_badge_data_gracefully(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [
                ['name' => 'Test Badge'], // Missing icon and description
            ],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('Certifications & Badges', $rendered);
        $this->assertStringContainsString('Test Badge', $rendered);
    }

    /**
     * Test that component handles missing testimonial data gracefully
     * 
     * @test
     */
    public function component_handles_missing_testimonial_data_gracefully(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [
                ['name' => 'John Doe'], // Missing location, text, and rating
            ],
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('What Travelers Say', $rendered);
        $this->assertStringContainsString('John Doe', $rendered);
    }

    /**
     * Test that component renders with background color
     * 
     * @test
     */
    public function component_renders_with_background_color(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('bg-white', $rendered);
    }

    /**
     * Test that component uses max-width container
     * 
     * @test
     */
    public function component_uses_max_width_container(): void
    {
        $view = View::make('components.trust.trust-section', [
            'ratings' => [],
            'travelerCount' => 1000,
            'legalBadges' => [],
            'testimonials' => [],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('max-w-7xl', $rendered);
        $this->assertStringContainsString('mx-auto', $rendered);
    }
}
